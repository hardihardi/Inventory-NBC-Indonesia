<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Item;
use App\Models\Sale;
use App\Models\Pembelian;
use Carbon\Carbon;

class NotificationComposer
{
    public function compose(View $view)
    {
        $notifications = [];
        $user = auth()->user();
        
        if (!$user) {
            $view->with('notifications', [])->with('notificationCount', 0);
            return;
        }

        // 1. Low Stock Items - Visible to Admin, Procurement, Supervisor, Staff
        if (in_array($user->role, ['admin', 'procurement', 'kepala_gudang', 'staff_gudang'])) {
            $lowStockItems = Item::whereColumn('stock', '<=', 'min_stock')->take(5)->get();
            foreach ($lowStockItems as $item) {
                $notifications[] = [
                    'type' => 'stock',
                    'title' => 'Stok Menipis',
                    'message' => "Produk {$item->name} sisa {$item->stock}.",
                    'icon' => 'fas fa-box-open',
                    'color' => 'warning',
                    'link' => route('inventory.items.index', ['stock' => 'low'])
                ];
            }
        }

        // 2. Overdue Piutang (Sales) - Visible to Admin, Procurement, Finance
        if (in_array($user->role, ['admin', 'procurement', 'finance'])) {
            $overdueSalesArr = Sale::with('customer')->where('payment_status', '!=', 'paid')
                ->where('due_date', '<', Carbon::today())
                ->take(3)
                ->get();
            foreach ($overdueSalesArr as $sale) {
                $notifications[] = [
                    'type' => 'receivable',
                    'title' => 'Piutang Jatuh Tempo',
                    'message' => "Inv: {$sale->invoice_number} (" . ($sale->customer->name ?? 'Cust') . ")",
                    'icon' => 'fas fa-hand-holding-usd',
                    'color' => 'danger',
                    'link' => route('penjualan.transaksi.index')
                ];
            }
        }

        // 3. Overdue Hutang (Purchases) - Visible to Admin, Procurement, Finance
        if (in_array($user->role, ['admin', 'procurement', 'finance'])) {
            $overduePurchasesArr = Pembelian::with('supplier')->where('payment_status', '!=', 'paid')
                ->where('due_date', '<', Carbon::today())
                ->take(3)
                ->get();
            foreach ($overduePurchasesArr as $pembelian) {
                $notifications[] = [
                    'type' => 'debt',
                    'title' => 'Hutang Jatuh Tempo',
                    'message' => "Beli: {$pembelian->purchase_number} (" . ($pembelian->supplier->name ?? 'Supp') . ")",
                    'icon' => 'fas fa-file-invoice-dollar',
                    'color' => 'danger',
                    'link' => route('pembelian.index')
                ];
            }
        }

        $view->with('notifications', $notifications);
        $view->with('notificationCount', count($notifications));
    }
}
