<x-filament::page>
  <div class="border border-gray-300 shadow-sm bg-white rounded-xl dark:bg-gray-800 p-6">

    <div class="md:flex space-y-4 md:space-y-0">
      <div>
        <p class="text-gray-500 dark:text-gray-300 font-medium">Reseller</p>
        <p class="text-gray-700 dark:text-gray-300">{{ $request->user->nama }}</p>
        <p class="text-gray-700 dark:text-gray-300">{{ $request->user->district->name }}</p>
      </div>
      <div class="md:ml-auto">
        <p class="text-gray-500 dark:text-gray-300 font-medium">Tanggal</p>
        <p class="text-gray-700 dark:text-gray-300">{{ $request->tanggal }}</p>
      </div>

      @if ($request->status == 'DIBATALKAN' || $request->status == 'SELESAI')
      <div>
        <p class="text-gray-500 dark:text-gray-300 font-medium">
            {{$request->status == 'DIBATALKAN' ? 'Tanggal dibatalkan' : 'Tanggal diterima'}}
        </p>
        <p class="text-gray-700 dark:text-gray-300">{{ $request->updated_at->format('Y-m-d') }}</p>
      </div>
      @endif

    </div>



    <div class="mt-16">
      <h1 class="text-xl mb-3 decoration-primary-500 underline underline-offset-4">Detail</h1>
      <table class="table-auto w-full mt-6 border-separate ">
        <thead>
          <tr>
            <th class="text-left text-gray-500 dark:text-gray-300 font-medium">Produk</th>
            <th class="text-gray-500 dark:text-gray-300 font-medium">QTY</th>
            <th class="text-right text-gray-500 dark:text-gray-300 font-medium">Harga</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($request->details as $detail)
            <tr>
              <td class="text-gray-700 dark:text-gray-300">{{ $detail->product->nama_produk }}</td>
              <td class="text-center text-gray-700 dark:text-gray-300">
                {{ $detail->jumlah_produk }}
              </td>
              <td class="text-right text-gray-700 dark:text-gray-300">
                <x-money amount="{{ $detail->harga }}" currency="IDR" convert />
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="text-right mt-10">
        <p class="text-gray-500 dark:text-gray-300">Total harga</p>
        <p class="text-2xl md:text-4xl">
          <x-money amount="{{ $request->total_harga }}" currency="IDR" convert />
        </p>
      </div>
    </div>

  </div>
</x-filament::page>
