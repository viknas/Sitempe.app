<x-filament::page>
  <div class="border border-gray-300 shadow-sm bg-white rounded-xl dark:bg-gray-800 p-6">

    <p class="text-2xl md:text-3xl text-primary-500 font-medium">
      {{ $request->code }}
    </p>

    <div class="md:flex space-y-4 md:space-y-0 mt-5">
      <div>
        <p class="text-gray-500 dark:text-gray-300 font-medium">Reseller</p>
        <p class="text-gray-700 text-sm dark:text-gray-300">{{ $request->user->nama }}</p>
        <p class="text-gray-700 text-sm dark:text-gray-300">{{ ucwords(strtolower($request->user->regency->name)) }}
        </p>
        <p class="text-gray-700 text-sm dark:text-gray-300">{{ ucwords(strtolower($request->user->district->name)) }}
        </p>
        <p class="text-gray-700 text-sm dark:text-gray-300">{{ $request->user->alamat ?? '-' }}</p>
      </div>
      <div class="md:ml-auto md:text-right">
        <p class="text-gray-500 dark:text-gray-300 font-medium">Tanggal</p>
        <p class="text-gray-700 text-sm dark:text-gray-300">{{ $request->tanggal }}</p>
      </div>

      @if ($request->status == 'DIBATALKAN' || $request->status == 'SELESAI')
        <div class="md:pl-6 md:text-right">
          <p class="text-gray-500 dark:text-gray-300 font-medium">
            {{ $request->status == 'DIBATALKAN' ? 'Tanggal dibatalkan' : 'Tanggal diterima' }}
          </p>
          <p class="text-gray-700 text-sm dark:text-gray-300">{{ $request->updated_at->format('Y-m-d') }}</p>
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

      @if (auth()->user()->isReseller())
        <x-filament::button class="mt-4" type="button" target="_blank" color="secondary" tag="a"
          :href="'https://wa.me/6282230724988?text=Halo admin TempeGo,%0asaya reseller TempeGo dengan nama: '.$request->user->nama. '%0aingin melakukan pembayaran untuk transaksi dengan nomor order: '.$request->code">
          Hubungi Pemilik
        </x-filament::button>
      @endif
    </div>

  </div>
</x-filament::page>
