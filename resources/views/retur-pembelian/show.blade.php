@extends('layouts.app')

@section('title', 'Detail Retur Pembelian')

@section('content')
  <div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
      <div class="mb-3 mb-md-0">
        <h4 class="mb-1 fw-bold text-gradient">
          <i class="fas fa-undo-alt me-2"></i>
          Detail Retur #{{ $returPembelian->return_number }}
        </h4>
        <p class="mb-0 text-muted small">
          Dibuat: {{ $returPembelian->created_at->isoFormat('DD MMM YYYY, HH:mm') }}
        </p>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
          <i class="fas fa-print me-1"></i> Cetak
        </button>
        <a href="{{ route('retur-pembelian.edit', $returPembelian) }}" class="btn btn-warning btn-sm text-white">
          <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('retur-pembelian.index') }}" class="btn btn-secondary btn-sm">
          <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
      </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="row g-4">
      {{-- KOLOM KIRI: INFORMASI RETUR --}}
      <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-header bg-white p-3 border-bottom">
            <h5 class="mb-0 fw-semibold">
              <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Retur
            </h5>
          </div>
          <div class="card-body p-0">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <span class="text-muted"><i class="fas fa-hashtag me-2 text-secondary"></i>Nomor Retur</span>
                <span class="fw-bold text-primary">{{ $returPembelian->return_number }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <span class="text-muted"><i class="fas fa-file-invoice me-2 text-secondary"></i>Ref. Pembelian</span>
                @if($returPembelian->pembelian)
                  <a href="{{ route('pembelian.show', $returPembelian->pembelian) }}"
                    class="fw-bold text-decoration-none">
                    <i class="fas fa-external-link-alt me-1 small"></i>#{{ $returPembelian->pembelian->purchase_number }}
                  </a>
                @else
                  <span class="badge bg-secondary">Tanpa Referensi</span>
                @endif
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <span class="text-muted"><i class="fas fa-building me-2 text-secondary"></i>Supplier</span>
                <span class="fw-semibold">{{ optional(optional($returPembelian->pembelian)->supplier)->name ?? 'N/A' }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <span class="text-muted"><i class="fas fa-calendar-alt me-2 text-secondary"></i>Tanggal Retur</span>
                <span class="fw-semibold">{{ $returPembelian->retur_date->isoFormat('DD MMMM YYYY') }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <span class="text-muted"><i class="fas fa-user-check me-2 text-secondary"></i>Diproses oleh</span>
                <span class="fw-semibold">{{ optional($returPembelian->user)->name ?? 'N/A' }}</span>
              </li>
            </ul>
          </div>

          {{-- Catatan --}}
          @if($returPembelian->notes)
          <div class="card-footer bg-light border-top p-3">
            <small class="fw-semibold text-muted d-block mb-1">
              <i class="fas fa-sticky-note me-1 text-info"></i>Catatan / Alasan Retur:
            </small>
            <p class="mb-0 text-dark">{{ $returPembelian->notes }}</p>
          </div>
          @endif
        </div>
      </div>

      {{-- KOLOM KANAN: ITEM YANG DIRETUR --}}
      <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-header bg-white p-3 border-bottom">
            <h5 class="mb-0 fw-semibold">
              <i class="fas fa-boxes me-2 text-primary"></i>Item yang Dikembalikan
              <span class="badge bg-primary ms-2">{{ $returPembelian->items->count() }} item</span>
            </h5>
          </div>
          <div class="card-body p-0">
            @if ($returPembelian->items->isNotEmpty())
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="retur-item-table">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-3" width="5%">#</th>
                      <th>Produk</th>
                      <th class="text-center" width="15%">Qty</th>
                      <th class="text-end" width="20%">Harga Satuan</th>
                      <th class="text-end pe-3" width="20%">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($returPembelian->items as $index => $item)
                      <tr>
                        <td data-label="#" class="ps-3 text-muted">{{ $index + 1 }}</td>
                        <td data-label="Produk">
                          <a href="{{ route('inventory.items.show', $item->item) }}"
                            class="text-dark fw-semibold text-decoration-none">
                            {{ $item->item_name }}
                          </a>
                          @if(optional($item->item)->sku)
                            <small class="d-block text-muted">SKU: {{ $item->item->sku }}</small>
                          @endif
                        </td>
                        <td data-label="Qty" class="text-center">
                          <span class="badge bg-warning text-dark px-3 py-2">
                            {{ $item->quantity }} {{ optional(optional($item->item)->unit)->short_name ?? '' }}
                          </span>
                        </td>
                        <td data-label="Harga" class="text-end">{{ $item->unit_price_formatted }}</td>
                        <td data-label="Subtotal" class="text-end pe-3 fw-bold text-primary">
                          {{ $item->subtotal_returned_formatted }}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot class="table-light">
                    <tr class="table-warning">
                      <td colspan="4" class="text-end fw-bold ps-3">
                        <i class="fas fa-money-bill-wave me-1"></i>Total Nilai Retur:
                      </td>
                      <td class="text-end pe-3 fw-bold text-dark fs-5">
                        {{ $returPembelian->total_returned_amount_formatted }}
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            @else
              <div class="p-5 text-center text-muted">
                <i class="fas fa-box-open fa-3x mb-3 text-secondary"></i>
                <p class="mb-0">Tidak ada item dalam retur ini.</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- Action Buttons Mobile --}}
    <div class="d-grid gap-2 d-md-none mt-4">
      <button onclick="window.print()" class="btn btn-outline-primary">
        <i class="fas fa-print me-1"></i> Cetak Retur
      </button>
      <a href="{{ route('retur-pembelian.edit', $returPembelian) }}" class="btn btn-warning text-white">
        <i class="fas fa-edit me-1"></i> Edit Retur
      </a>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .text-gradient {
      background: linear-gradient(135deg, var(--bs-primary), var(--bs-warning));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .table th {
      font-weight: 600;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .card {
      border-radius: 12px;
    }

    .card-header {
      border-radius: 12px 12px 0 0 !important;
    }

    /* Tampilan Kartu Responsif untuk Tabel */
    @media (max-width: 767.98px) {
      #retur-item-table thead {
        display: none;
      }

      #retur-item-table tbody tr {
        display: block;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      }

      #retur-item-table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        border: none;
        border-bottom: 1px solid #f0f0f0;
      }

      #retur-item-table tbody td:last-child {
        border-bottom: none;
      }

      #retur-item-table tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #6c757d;
        margin-right: 1rem;
        flex-shrink: 0;
      }

      #retur-item-table tfoot tr {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 1rem;
      }

      #retur-item-table tfoot td {
        border: none;
        padding: 0 !important;
      }

      #retur-item-table tfoot td[colspan="4"] {
        text-align: left !important;
      }
    }

    /* Print styles */
    @media print {
      .btn, .sidebar, .navbar, .d-flex.gap-2 {
        display: none !important;
      }
      .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
      }
      .container-fluid {
        padding: 0 !important;
      }
    }
  </style>
@endpush

@push('scripts')
  <script>
    $(document).on('click', '.delete-btn', function (e) {
      e.preventDefault();

      const button = $(this);
      const url = button.data('url');
      const returnName = button.data('name');
      const csrfToken = $('meta[name="csrf-token"]').attr('content');

      Swal.fire({
        title: 'Anda Yakin?',
        html: `Menghapus retur <b>#${returnName}</b> akan menambahkan kembali stok ke inventaris. Aksi ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: url,
            type: 'POST',
            data: {
              _token: csrfToken,
              _method: 'DELETE'
            },
            success: function (response) {
              Swal.fire(
                'Berhasil Dihapus!',
                response.success,
                'success'
              ).then(() => {
                window.location.href = "{{ route('retur-pembelian.index') }}";
              });
            },
            error: function (xhr) {
              let errorMessage = 'Terjadi kesalahan saat menghapus data.';
              if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
              }
              Swal.fire('Gagal!', errorMessage, 'error');
            }
          });
        }
      });
    });
  </script>
@endpush