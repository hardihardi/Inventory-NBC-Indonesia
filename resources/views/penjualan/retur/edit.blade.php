@extends('layouts.app')

@section('title', 'Edit Retur Penjualan')

@section('content')
  <div class="container-fluid py-0">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <div>
        <h4 class="mb-0 text-gray-800">Edit Retur: {{ $retur->return_number }}</h4>
        <p class="mb-0 text-muted" style="font-size: 0.8rem">Perbarui detail retur penjualan</p>
      </div>
      <div>
        <a href="{{ route('penjualan.retur.index') }}" class="btn btn-secondary btn-sm">
          <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
      </div>
    </div>

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form action="{{ route('penjualan.retur.update', $retur) }}" method="POST" id="sale-return-form">
      @csrf
      @method('PUT')

      <div class="row g-4">
        <div class="col-lg-4">
          <!-- Information Card -->
          <div class="card shadow-sm mb-4 h-100">
            <div class="card-header bg-primary text-white py-3">
              <h6 class="m-0 font-weight-bold"><i class="fas fa-info-circle me-2"></i> Informasi Retur</h6>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label for="sale_id" class="form-label">Faktur Penjualan</label>
                <select class="form-select select2" id="sale_id" name="sale_id">
                  <option value="">-- Pilih Faktur (Opsional) --</option>
                  @foreach ($sales as $sale)
                    <option value="{{ $sale->id }}"
                      data-sale-details="{{ json_encode($sale->items->map(function ($item) {
                        return [
                          'id' => $item->item_id,
                          'name' => $item->item_name,
                          'quantity' => $item->quantity,
                          'price_per_unit' => $item->unit_price,
                          'unit' => $item->item->unit->short_name ?? ($item->item->unit->name ?? '')
                        ];
                      })) }}"
                      {{ old('sale_id', $retur->sale_id) == $sale->id ? 'selected' : '' }}>
                      {{ $sale->invoice_number }} ({{ optional($sale->customer)->name ?? ($sale->customer_name ?? 'Umum') }})
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="return_date" class="form-label">Tanggal Retur</label>
                <input type="date" class="form-control" id="return_date" name="return_date"
                  value="{{ old('return_date', $retur->return_date->format('Y-m-d')) }}" required>
              </div>

              <div class="mb-3">
                <label for="reason" class="form-label">Alasan Retur</label>
                <textarea class="form-control" id="reason" name="reason" rows="3" required>{{ old('reason', $retur->reason) }}</textarea>
              </div>

              <div class="mb-0">
                <label for="notes" class="form-label">Catatan Tambahan</label>
                <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes', $retur->notes) }}</textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
          <!-- Items Card -->
          <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white py-3">
              <h6 class="m-0 font-weight-bold"><i class="fas fa-boxes me-2"></i> Daftar Produk Diretur</h6>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label for="item_select" class="form-label">Tambah Produk Manual</label>
                <select class="form-select select2" id="item_select">
                  <option value="">-- Cari atau Pilih Produk --</option>
                  @foreach (App\Models\Item::all() as $item)
                    <option value="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}"
                      data-unit="{{ optional($item->unit)->short_name ?? (optional($item->unit)->name ?? '') }}">
                      {{ $item->name }} (Rp {{ number_format($item->price, 0, ',', '.') }})
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="returned-items-table">
                  <thead class="bg-light">
                    <tr>
                      <th width="40%">Nama Produk</th>
                      <th class="text-end">Harga</th>
                      <th width="150px">Qty</th>
                      <th class="text-end">Subtotal</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- JS populated -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Refund Card -->
          <div class="card shadow-sm mb-4 border-left-success">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Nilai Barang</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_display">Rp 0</div>
                  <input type="hidden" name="total_returned_amount_raw" id="total_returned_amount_raw" value="0">
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="number" class="form-control border-success text-success fw-bold fs-5" id="refund_amount" name="refund_amount"
                      value="{{ old('refund_amount', $retur->refund_amount) }}" min="0" step="1">
                    <label for="refund_amount" class="text-success">Jumlah Refund (Rp)</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="d-grid gap-3 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary btn-sm px-5 py-2 text-white shadow-sm" id="process-return-btn">
              <i class="fas fa-save me-2"></i> Update Data Retur
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('styles')
  <style>
    .card { border-radius: 10px; border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
    .select2-container .select2-selection--single { height: 50px; border-color: #ced4da; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 50px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 50px; }
    .form-floating>.form-control { height: 60px; }
  </style>
@endpush

@push('scripts')
  <script>
    $(document).ready(function () {
      $('.select2').select2({ placeholder: "-- Pilih --", width: '100%' });

      var returnedItems = {
        @foreach($retur->items as $item)
          "{{ $item->item_id }}": {
            name: "{{ optional($item->item)->name ?? 'N/A' }}",
            price_per_unit: {{ $item->price_per_unit }},
            quantity: {{ $item->quantity }},
            unit: "{{ optional($item->item->unit)->short_name ?? (optional($item->item->unit)->name ?? '') }}",
            max: undefined // Will be set if invoice is selected
          },
        @endforeach
      };

      function updateTable() {
        var total = 0;
        var $tbody = $('#returned-items-table tbody');
        $tbody.empty();

        for (var id in returnedItems) {
          var item = returnedItems[id];
          var subtotal = item.quantity * item.price_per_unit;
          total += subtotal;

          var row = `
            <tr>
              <td>
                <span class="fw-bold text-dark">${item.name}</span>
                <input type="hidden" name="returned_items[${id}][item_id]" value="${id}">
              </td>
              <td class="text-end">Rp ${numberFormat(item.price_per_unit)}</td>
              <td>
                <div class="input-group input-group-sm">
                  <input type="number" class="form-control quantity-input" name="returned_items[${id}][quantity]" 
                    value="${item.quantity}" min="1" ${item.max ? `max="${item.max}"` : ''} data-id="${id}">
                  <span class="input-group-text">${item.unit || ''}</span>
                </div>
                ${item.max ? `<small class="text-muted">Maks: ${item.max} ${item.unit}</small>` : ''}
              </td>
              <td class="text-end fw-bold text-primary">Rp ${numberFormat(subtotal)}</td>
              <td class="text-center">
                <button type="button" class="btn btn-outline-danger btn-sm rounded-circle remove-item" data-id="${id}">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </td>
            </tr>
          `;
          $tbody.append(row);
        }

        $('#total_returned_amount_raw').val(total);
        $('#total_display').text('Rp ' + numberFormat(total));
        
        var $btn = $('#process-return-btn');
        $btn.prop('disabled', Object.keys(returnedItems).length === 0);
      }

      $('#sale_id').change(function () {
        var details = $(this).find('option:selected').data('sale-details');
        if (details) {
          // If multiple items are in returnedItems, ask user if they want to merge or replace? 
          // For edit, we might just want to update max quantities for existing items if they match the invoice.
          details.forEach(function(d) {
            if (returnedItems[d.id]) {
              returnedItems[d.id].max = d.quantity;
            }
          });
          updateTable();
        }
      });

      $('#item_select').change(function () {
        var $opt = $(this).find('option:selected');
        var id = $opt.val();
        if (id) {
          if (!returnedItems[id]) {
            returnedItems[id] = {
              name: $opt.data('name'),
              price_per_unit: $opt.data('price'),
              quantity: 1,
              unit: $opt.data('unit'),
              max: undefined
            };
          } else {
            returnedItems[id].quantity++;
          }
          updateTable();
          $(this).val('').trigger('change');
        }
      });

      $('#returned-items-table').on('input', '.quantity-input', function () {
        var id = $(this).data('id');
        var val = parseInt($(this).val()) || 1;
        var max = $(this).attr('max') ? parseInt($(this).attr('max')) : Infinity;
        
        if (val > max) {
          val = max;
          $(this).val(max);
          Swal.fire('Batas Terlampaui', 'Kuantitas retur tidak boleh melebihi jumlah di faktur.', 'warning');
        }
        
        returnedItems[id].quantity = val;
        updateTable();
      });

      $('#returned-items-table').on('click', '.remove-item', function () {
        delete returnedItems[$(this).data('id')];
        updateTable();
      });

      function numberFormat(n) { return new Intl.NumberFormat('id-ID').format(n); }
      
      updateTable();
      // Trigger sale_id change to set max limits if editing a return from an invoice
      if ($('#sale_id').val()) {
        $('#sale_id').trigger('change');
      }
    });
  </script>
@endpush
