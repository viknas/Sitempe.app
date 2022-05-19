<x-filament::page>
  <div class="border border-gray-300 shadow-sm bg-white rounded-xl dark:bg-gray-800 p-6">

    <div class="md:flex">
      <div class="md:mr-9 mb-3">
        <p class="text-gray-500 dark:text-gray-300 font-medium">Reseller</p>
        <span class="text-gray-700 dark:text-gray-300">{{ $request->user->nama }}</span>
      </div>
      <div>
        <p class="text-gray-500 dark:text-gray-300 font-medium">Tanggal</p>
        <span class="text-gray-700 dark:text-gray-300">{{ $request->tanggal }}</span>
      </div>
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
        <p class="text-4xl">
          <x-money amount="{{ $request->total_harga }}" currency="IDR" convert />
        </p>
      </div>
    </div>

  </div>
</x-filament::page>
