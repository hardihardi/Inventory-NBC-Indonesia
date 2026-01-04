@extends('layouts.app')

@section('title', 'Edit Transaksi Penjualan')

@section('content')
  <div class="container-fluid py-0">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <div>
        <h4 class="mb-0 text-gray-800">Edit Transaksi: {{ $transaksi->invoice_number }}</h4>
        <p class="mb-0 text-muted" style="font-size: 0.8rem">Perbarui detail transaksi penjualan</p>
      </div>
      <div>
        <a href="{{ route('penjualan.transaksi.index') }}" class="btn btn-secondary btn-sm">
          <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
      </div>
    </div>

    <form action="{{ route('penjualan.transaksi.update', $transaksi) }}" method="POST" id="sale-form">
      @csrf
      @method('PUT')

      <!-- Customer Information Card -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white py-3">
          <h6 class="m-0 font-weight-bold">
            <i class="fas fa-user me-2"></i> Informasi Pelanggan
          </h6>
        </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="customer_id" class="form-label">Pilih Pelanggan</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
              <select class="form-select select2-customer" id="customer_id" name="customer_id">
                <option value="">-- Pelanggan Umum --</option>
                @foreach ($customers as $customer)
                  <option value="{{ $customer->id }}" data-name="{{ $customer->name }}" data-phone="{{ $customer->phone }}"
                    {{ (old('customer_id', $transaksi->customer_id) == $customer->id) ? 'selected' : '' }}>
                    {{ $customer->name }} ({{ $customer->phone ?? 'No Phone' }})
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <label for="customer_name" class="form-label">Nama Pelanggan (Display)</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" id="customer_name" name="customer_name"
                value="{{ old('customer_name', $transaksi->customer_name) }}" placeholder="Nama Pelanggan">
            </div>
          </div>
          <div class="col-md-12">
            <label for="notes" class="form-label">Catatan</label>
            <textarea class="form-control" id="notes" name="notes" rows="1"
              placeholder="Catatan tambahan (Opsional)">{{ old('notes', $transaksi->notes) }}</textarea>
          </div>
        </div>
      </div>
      </div>

      <!-- Items Selection Card -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white py-3">
          <h6 class="m-0 font-weight-bold">
            <i class="fas fa-shopping-cart me-2"></i> Pilih Produk
          </h6>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-4">
            <div class="col-md-8">
              <label for="item_select" class="form-label">Cari Produk</label>
              <select class="form-select select2" id="item_select">
                <option value="">-- Pilih Produk --</option>
                @foreach ($items as $item)
                  <option value="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}"
                    data-stock="{{ $item->stock }}">
                    {{ $item->name }} (Stok Saat Ini: {{ $item->stock }} {{ $item->unit->short_name ?? ($item->unit->name ?? '') }})
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover mb-0" id="selected-items-table">
              <thead class="bg-light">
                <tr>
                  <th width="35%">Nama Produk</th>
                  <th class="text-end">Harga</th>
                  <th width="120px">Qty</th>
                  <th class="text-end">Subtotal</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <!-- Items will be populated by JavaScript -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Payment Summary Card -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white py-3">
          <h6 class="m-0 font-weight-bold">
            <i class="fas fa-receipt me-2"></i> Ringkasan Pembayaran
          </h6>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control" id="total_amount" value="Rp 0" readonly>
                <label for="total_amount">Subtotal</label>
                <input type="hidden" name="total_amount_raw" id="total_amount_raw" value="0">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <input type="number" class="form-control" id="discount_amount" name="discount_amount"
                  value="{{ old('discount_amount', $transaksi->discount_amount) }}" min="0">
                <label for="discount_amount">Diskon (Rp)</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <input type="number" class="form-control" id="tax_amount" name="tax_amount"
                  value="{{ old('tax_amount', $transaksi->tax_amount) }}" min="0">
                <label for="tax_amount">Pajak (Rp)</label>
              </div>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" class="form-control fw-bold fs-5" id="grand_total" value="Rp 0" readonly>
                <label for="grand_total">Grand Total</label>
                <input type="hidden" name="grand_total_raw" id="grand_total_raw" value="0">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <select class="form-select" id="payment_method" name="payment_method" required>
                  <option value="cash" {{ (old('payment_method', $transaksi->payment_method) == 'cash') ? 'selected' : '' }}>Cash</option>
                  <option value="transfer" {{ (old('payment_method', $transaksi->payment_method) == 'transfer') ? 'selected' : '' }}>Transfer</option>
                </select>
                <label for="payment_method">Metode Pembayaran</label>
              </div>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-floating">
                <input type="number" class="form-control" id="paid_amount" name="paid_amount"
                  value="{{ old('paid_amount', $transaksi->paid_amount) }}" min="0" required>
                <label for="paid_amount">Jumlah Dibayar</label>
                <button type="button" class="btn btn-sm btn-outline-info position-absolute end-0 top-0 mt-2 me-2" id="pay-exact-btn" style="z-index: 10;">
                  Bayar Pas
                </button>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" class="form-control fw-bold fs-5 text-primary" id="change_amount" value="Rp 0"
                  readonly>
                <label for="change_amount">Kembalian</label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-grid gap-3 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-warning btn-sm px-4 text-white" id="process-sale-btn">
          <i class="fas fa-save me-2"></i> Update Transaksi
        </button>
      </div>
    </form>
  </div>
@endsection

@push('styles')
  <style>
    .card { border-radius: 10px; border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
    .select2-container .select2-selection--single { height: 58px; border-color: #ced4da; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 58px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 58px; }
    .form-floating>.form-control { height: 58px; }
    .quantity-input { width: 80px; text-align: center; }
  </style>
@endpush

@push('scripts')
  <script>
    $(document).ready(function () {
      $('.select2').select2({ placeholder: "Cari produk", width: '100%' });

      $('.select2-customer').select2({
        placeholder: "Pilih Pelanggan",
        allowClear: true,
        width: '100%'
      });

      $('#customer_id').change(function() {
        var $selected = $(this).find('option:selected');
        var name = $selected.data('name') || '';
        $('#customer_name').val(name);
      });

      // Initial data from server
      var selectedItems = {
        @foreach($transaksi->items as $item)
          "{{ $item->item_id }}": {
            name: "{{ $item->item_name }}",
            price: {{ $item->unit_price }},
            stock: {{ $item->item->stock + $item->quantity }}, // Stock available if this is reverted
            quantity: {{ $item->quantity }}
          },
        @endforeach
      };

      function updateSelectedItemsTable() {
        var totalAmount = 0;
        var $tableBody = $('#selected-items-table tbody');
        $tableBody.empty();

        for (var itemId in selectedItems) {
          var item = selectedItems[itemId];
          var subtotal = item.quantity * item.price;
          totalAmount += subtotal;

          var row = `
            <tr>
              <td>${item.name}<input type="hidden" name="items[${itemId}][item_id]" value="${itemId}"><input type="hidden" name="items[${itemId}][price_per_unit]" value="${item.price}"></td>
              <td class="text-end">Rp ${numberFormat(item.price)}</td>
              <td><input type="number" class="form-control form-control-sm quantity-input" name="items[${itemId}][quantity]" value="${item.quantity}" min="1" max="${item.stock}" data-item-id="${itemId}"></td>
              <td class="text-end item-subtotal">Rp ${numberFormat(subtotal)}</td>
              <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="${itemId}"><i class="fas fa-trash"></i></button></td>
            </tr>
          `;
          $tableBody.append(row);
        }

        $('#total_amount_raw').val(totalAmount);
        $('#total_amount').val('Rp ' + numberFormat(totalAmount));
        calculateGrandTotal();
      }

      function calculateGrandTotal() {
        var total = parseFloat($('#total_amount_raw').val()) || 0;
        var discount = parseFloat($('#discount_amount').val()) || 0;
        var tax = parseFloat($('#tax_amount').val()) || 0;
        var grandTotal = total - discount + tax;
        $('#grand_total_raw').val(grandTotal);
        $('#grand_total').val('Rp ' + numberFormat(grandTotal));
        calculateChange();
      }

      function calculateChange() {
        var grandTotal = parseFloat($('#grand_total_raw').val()) || 0;
        var paid = parseFloat($('#paid_amount').val()) || 0;
        $('#change_amount').val('Rp ' + numberFormat(paid - grandTotal));
        $('#process-sale-btn').prop('disabled', paid < grandTotal || grandTotal <= 0);
      }

      $('#item_select').change(function () {
        var $opt = $(this).find('option:selected');
        var id = $opt.val();
        if (id) {
          if (!selectedItems[id]) {
            selectedItems[id] = { name: $opt.data('name'), price: $opt.data('price'), stock: $opt.data('stock'), quantity: 1 };
          } else {
            selectedItems[id].quantity++;
          }
          updateSelectedItemsTable();
          $(this).val('').trigger('change');
        }
      });

      $('#selected-items-table').on('input', '.quantity-input', function () {
        var id = $(this).data('item-id');
        selectedItems[id].quantity = parseInt($(this).val()) || 1;
        updateSelectedItemsTable();
      });

      $('#selected-items-table').on('click', '.remove-item', function () {
        delete selectedItems[$(this).data('item-id')];
        updateSelectedItemsTable();
      });

      $('#discount_amount, #tax_amount, #paid_amount').on('input', calculateGrandTotal);

      $('#pay-exact-btn').click(function() {
        var grandTotal = parseFloat($('#grand_total_raw').val()) || 0;
        $('#paid_amount').val(grandTotal).trigger('input');
      });

      function numberFormat(n) { return new Intl.NumberFormat('id-ID').format(n); }

      updateSelectedItemsTable();
    });
  </script>
@endpush
