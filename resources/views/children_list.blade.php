<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Daftar Anak') }}
    </h2>

    <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="p-6">
            @if($children->isEmpty())
                <p class="text-gray-600">Anda belum mendaftarkan anak.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Lengkap
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Lahir
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status Akun
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($children as $child)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $child->relatedMember->firstname }} {{ $child->relatedMember->lastname }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $child->relatedMember->dateofbirth }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($child->relatedMember->user_id)
                                        <span class="text-green-600">Sudah memiliki akun</span>
                                    @else
                                        <span class="text-red-600">Belum memiliki akun</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(!$child->relatedMember->user_id)
                                        <a href="{{ route('member.createChildAccount', encrypt($child->relatedMember->id)) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Buatkan Akun
                                        </a>
                                    @else
                                        <span class="text-gray-500">Akun sudah ada</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
