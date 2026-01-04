<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Pembelian;
use App\Models\CashFlow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reference_type' => 'required|in:Sale,Pembelian',
            'reference_id' => 'required|integer',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $model = null;
            $cashFlowType = 'in'; // Default for Sale/Receivable
            $category = 'Piutang';
            $refId = $request->reference_id;

            if ($request->reference_type === 'Sale') {
                $model = Sale::findOrFail($refId);
                $cashFlowType = 'in';
                $category = 'Pelunasan Piutang';
                $remaining = $model->grand_total - $model->paid_amount;
                $refNumber = $model->invoice_number;
            } else {
                $model = Pembelian::findOrFail($refId);
                $cashFlowType = 'out';
                $category = 'Pelunasan Hutang';
                $remaining = $model->total_amount - $model->paid_amount;
                $refNumber = $model->purchase_number;
            }

            // --- VALIDASI SALDO ---
            if ($request->amount > ($remaining + 0.01)) { // Tolerance for floating point
                return redirect()->back()->with('error', "Gagal: Jumlah bayar (Rp " . number_format($request->amount, 0, ',', '.') . ") melebihi sisa tagihan (Rp " . number_format($remaining, 0, ',', '.') . ").");
            }

            // 1. Create Payment Record
            $payment = Payment::create([
                'reference_type' => $request->reference_type,
                'reference_id' => $refId,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'user_id' => Auth::id(),
            ]);

            // 2. Update Model paid_amount and status
            $model->paid_amount += $request->amount;
            $grandTotal = $request->reference_type === 'Sale' ? $model->grand_total : $model->total_amount;

            if ($model->paid_amount >= ($grandTotal - 0.01)) {
                $model->payment_status = 'paid';
            } else {
                $model->payment_status = 'partial';
            }
            $model->save();

            // 3. Record Cash Flow
            CashFlow::create([
                'type' => $cashFlowType,
                'amount' => $request->amount,
                'transaction_date' => $request->payment_date,
                'category' => $category,
                'reference_type' => $request->reference_type,
                'reference_id' => $model->id,
                'notes' => "Pelunasan " . $refNumber,
                'user_id' => Auth::id()
            ]);

            // 4. Log Activity
            \App\Models\ActivityLog::log("Catat Pembayaran", "Mencatat pembayaran {$category} untuk {$refNumber} sebesar Rp " . number_format($request->amount, 0, ',', '.'));

            DB::commit();
            return redirect()->back()->with('success', 'Pembayaran berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mencatat pembayaran: ' . $e->getMessage());
        }
    }
}
