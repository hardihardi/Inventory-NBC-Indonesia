<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Menampilkan halaman profil perusahaan.
     */
    public function index()
    {
        // Ambil data pertama, atau buat data default jika tabel masih kosong
        $company = CompanySetting::firstOrCreate(
            ['id' => 1],
            ['name' => 'TB. SOGOL ANUGRAH MANDIRI']
        );
        return view('settings.company.index', compact('company'));
    }

    /**
     * Menampilkan form untuk mengedit profil perusahaan.
     */
    public function edit()
    {
        $company = CompanySetting::firstOrCreate(
            ['id' => 1],
            ['name' => 'TB. SOGOL ANUGRAH MANDIRI']
        );
        return view('settings.company.edit', compact('company'));
    }

    /**
     * Memperbarui profil perusahaan di database.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|mimes:ico,png|max:1024',
            'invoice_prefix' => 'nullable|string|max:10',
            'invoice_format' => 'nullable|string|max:100',
            'sj_prefix' => 'nullable|string|max:10',
            'sj_format' => 'nullable|string|max:100',
        ]);

        $company = CompanySetting::firstOrCreate(['id' => 1]);
        $data = $request->except(['logo', 'favicon']);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
            // Simpan logo baru dan dapatkan path-nya
            $data['logo'] = $request->file('logo')->store('company_logo', 'public');
        }

        if ($request->hasFile('favicon')) {
            // Hapus favicon lama jika ada
            if ($company->favicon && Storage::disk('public')->exists($company->favicon)) {
                Storage::disk('public')->delete($company->favicon);
            }
            // Simpan favicon baru dan dapatkan path-nya
            $data['favicon'] = $request->file('favicon')->store('company_logo', 'public');
        }

        $company->update($data);

        return redirect()->route('settings.company.index')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
