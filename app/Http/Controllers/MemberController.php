<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Position;
use App\Models\Relation;
use App\Models\MemberRelation;

class MemberController extends Controller
{
    public function index() : View
    {   
        // Mengambil semua data anggota beserta cabang-nya menggunakan eager loading (dengan relasi cabang)
        $members = Member::with('branch', 'role', 'user', 'position')->paginate(3);
        
        return view('member.index', compact('members'));
    }
    
    public function create() : View
    {   
        $branches = Branch::where('status', 'Active')->get();

        $branchoptions = $branches->pluck('name', 'id');

        $roles = Role::where('id', '!=', 1)->get();

        $roleoptions = $roles->pluck('name', 'id');

        $positions = Position::where('status', 'Active')->get();

        $positionoptions = $positions->pluck('name', 'id');

        return view('member.add', compact('branchoptions', 'roleoptions', 'positionoptions'));
    }

    public function store(Request $request) : RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'firstname'         => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'lastname'          => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'dateofbirth'       => 'required|date',
            'address'           => 'required|string',
            'role_id'           => 'required|exists:roles,id',
            'position_id'       => 'required|exists:positions,id',
            'branch_id'         => 'required|exists:branches,id',
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'          => ['required', Rules\Password::defaults()],

        ], [
            'firstname.regex'       => 'Harap hanya memasukan huruf saja.',
            'lastname.regex'        => 'Harap hanya memasukan huruf saja.',
        ]);

        $fullname = $request->input('firstname') . ' ' . $request->input('lastname');

        $user = User::create([
            'email' => $request->email,
            'name'  => $fullname,
            'password' => Hash::make($request->password),
        ]);

        Member::create([
            'firstname'         => $request->input('firstname'),
            'lastname'          => $request->input('lastname'),
            'dateofbirth'       => $request->input('dateofbirth'),
            'status'            => 'Active',
            'address'           => $request->input('address'),
            'role_id'           => $request->input('role_id'),
            'position_id'       => $request->input('position_id'),
            'branch_id'         => $request->input('branch_id'),
            'user_id'           => $user->id,
        ]);
        return redirect()->route('member.index')->with(['success' => 'Data Anggota Berhasil Disimpan!']);

    }

    public function show($encryptedId): View
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $member = Member::with('user')->findOrFail($id);

        $branch = Branch::where('status', 'Active')->get();

        $branchoptions = $branch->pluck('name', 'id');

        $roles = Role::where('id', '!=', 1)->get();

        $roleoptions = $roles->pluck('name', 'id');

        $positions = Position::where('status', 'Active')->get();

        $positionoptions = $positions->pluck('name', 'id');

        //render view with product
        return view('member.show', compact('member', 'branchoptions', 'roleoptions', 'positionoptions'));
    }

    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Ambil data anggota dan user
        $member = Member::findOrFail($id);
        $user = User::findOrFail($member->user_id);
        
        $request->validate([
            'firstname'         => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'lastname'          => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'dateofbirth'       => 'required|date',
            'status'            => 'required|in:Active,Inactive',
            'address'           => 'required|string',
            'role_id'           => 'required|exists:roles,id',
            'position_id'       => 'required|exists:positions,id',
            'branch_id'         => 'required|exists:branches,id',
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],  // Pastikan email unik, kecuali untuk user saat ini
            'password'          => ['nullable', Rules\Password::defaults()],  // Password bersifat opsional saat update
        ], [
            'firstname.regex'       => 'Harap hanya memasukan huruf saja.',
            'lastname.regex'        => 'Harap hanya memasukan huruf saja.',
        ]);

        $fullname = $request->input('firstname') . ' ' . $request->input('lastname');

        // Temukan user yang terkait dengan anggota menggunakan ID
        $member = Member::findOrFail($id);
        $user = User::findOrFail($member->user_id);

        // Update data user
        $user->update([
            'email' => $request->email,
            'name'  => $fullname,
            'password' => $request->password ? Hash::make($request->password) : $user->password,  // Update password hanya jika diisi
        ]);

        // Update data anggota
        $member->update([
            'firstname'         => $request->input('firstname'),
            'lastname'          => $request->input('lastname'),
            'dateofbirth'       => $request->input('dateofbirth'),
            'status'            => $request->input('status'),
            'address'           => $request->input('address'),
            'role_id'           => $request->input('role_id'),
            'position_id'       => $request->input('position_id'),
            'branch_id'         => $request->input('branch_id'),
            'user_id'           => $user->id,
        ]);

        return redirect()->route('member.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function destroy($encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Temukan anggota berdasarkan ID
        $member = Member::findOrFail($id);

        // Temukan user yang terkait dengan anggota (melalui foreign key users_id)
        $user = User::findOrFail($member->user_id);

        // Hapus anggota
        $member->delete();

        // Hapus user yang terkait dengan anggota
        $user->delete();

        // Redirect kembali ke halaman index anggota dengan pesan sukses
        return redirect()->route('member.index')->with('success', 'Data Anggota dan Akun User berhasil dihapus!');
    }

    public function createChildForm() {

        $branches = Branch::where('status', 'Active')->get();
        $branchoptions = $branches->pluck('name', 'id');

        return view('register_child', compact('branchoptions'));
    }

    public function storeChild(Request $request) : RedirectResponse
    {
        $request->validate([
            'firstname'         => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'lastname'          => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'dateofbirth'       => 'required|date',
            'address'           => 'required|string',
            'branch_id'         => 'required|exists:branches,id',
        ]);

        // Temukan user (orang tua) yang sedang login
        $parent = Auth::user();
        $parentMember = Member::where('user_id', $parent->id)->first();

        $role = Role::where('name', 'Jemaat')->first();
        if (!$role) {
            return redirect()->back()->withErrors('Role "Jemaat" tidak ditemukan.');
        }

        // Dapatkan position_id berdasarkan nama "Jemaat"
        $position = Position::where('name', 'Jemaat')->first();
        if (!$position) {
            return redirect()->back()->withErrors('Posisi "Jemaat" tidak ditemukan.');
        }

        $childMember = Member::create([
            'firstname'         => $request->input('firstname'),
            'lastname'          => $request->input('lastname'),
            'dateofbirth'       => $request->input('dateofbirth'),
            'status'            => 'Active',
            'address'           => $request->input('address'),
            'branch_id'         => $request->input('branch_id'),
            'role_id'           => $role->id, // Isi role_id secara manual
            'position_id'       => $position->id, // Isi position_id secara manual
            'user_id'           => null,  // Anak tidak memiliki akun user
        ]);
        // Dapatkan relation ID untuk "Anak"
        $childRelation = Relation::where('name', 'Anak')->firstOrFail();

        // Simpan relasi orang tua dan anak di tabel member_relation
        MemberRelation::create([
            'member_id'         => $parentMember->id, // Orang tua
            'related_member_id' => $childMember->id,  // Anak
            'relation_id'       => $childRelation->id, // Relasi: Anak
        ]);

        return redirect()->route('home')->with('success', 'Anak berhasil didaftarkan!');
    }

    public function showChildrenList() : View
    {
        // Dapatkan data user (orang tua) yang sedang login
        $parent = Auth::user();

        // Dapatkan anggota orang tua
        $parentMember = Member::where('user_id', $parent->id)->first();

        // Cari semua anak dari parentMember melalui tabel member_relation
        $children = MemberRelation::with('relatedMember')
            ->where('member_id', $parentMember->id)
            ->whereHas('relation', function ($query) {
                $query->where('name', 'Anak'); // Hanya relasi anak
            })
            ->get();

        // Kirim data anak ke view
        return view('children_list', compact('children'));
    }


    public function createChildAccount($encryptedId): View
    {
        $id = decrypt($encryptedId);

        // Cari data anak berdasarkan member_id
        $child = Member::findOrFail($id);

        // Pastikan anak tidak memiliki akun user
        if ($child->user_id) {
            return redirect()->back()->withErrors('Anak ini sudah memiliki akun.');
        }

        // Kirim data anak ke view untuk menampilkan form pendaftaran akun
        return view('register_child_account', compact('child'));
    }


    public function storeChildAccount(Request $request, $encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Validasi email dan password (tidak memerlukan validasi nama lagi)
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Cari data anak berdasarkan member_id
        $child = Member::findOrFail($id);

        // Buat akun user untuk anak
        $user = User::create([
            'name' => $child->firstname . ' ' . $child->lastname, // Gabungkan nama depan dan belakang
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Perbarui data anak dengan user_id yang baru dibuat
        $child->update([
            'user_id' => $user->id,
        ]);

        return redirect()->route('home')->with('success', 'Akun untuk anak berhasil dibuat.');
    }



}