<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\DB;



class RoleController extends Controller
{
    //
    public function index()
    {
        $roles = Role::where('name', '!=', 'SuperAdmin')->paginate(10);

        return view('role', compact('roles'));
    }

    public function create() : View
    {
        DB::statement("SET SQL_MODE=''");

        $role_permission = Permission::select('name','id')->groupBy('name')->get();

        $custom_permission = array();

        foreach($role_permission as $per){

            $key = substr($per->name, 0, strpos($per->name, "."));

            if(str_starts_with($per->name, $key)){
                
                $custom_permission[$key][] = $per;
            }
        }
        return view('role.tambah')->with('permissions', $custom_permission);
    }

    public function store(Request $request)
    {   
        $request->validate([

            'name' => 'required|unique:roles,name',
        ]);
    
        $role = Role::create([
            'name' => $request->name,
        ]);
    
        if($request->permissions){
    
            foreach ($request->permissions as $permissionId) {
                $permission = Permission::findById($permissionId);  // pastikan kamu mengimpor Spatie\Permission\Models\Permission
                $role->givePermissionTo($permission);
            }
        }
        
        return redirect()->route('role.index')->with('success', 'Role berhasil dibuat!');
    }

    public function show($encryptedId): View
    {
        $id = decrypt($encryptedId);

        $role = Role::with('permissions')->find($id);

        DB::statement("SET SQL_MODE=''");

        $role_permission = Permission::select('name','id')->groupBy('name')->get();

        $custom_permission = array();

        foreach($role_permission as $per){

            $key = substr($per->name, 0, strpos($per->name, "."));

            if(str_starts_with($per->name, $key)){

                $custom_permission[$key][] = $per;
            }

        }

        //render view with product
        return view('role.tampil', compact('role'))->with('permissions',$custom_permission);
    }

    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);
        
        // $role = Role::where('id',$id)->first();

        // $request->validate([
        //     'name' => 'required|unique:roles,name',
        // ]);

        // $role->update([
        //     "name" => $request->name
        // ]);

        // $role->syncPermissions($request->permissions);


        // $request->validate([
        //     'nama'         => 'required|unique:roles,name',

        // ]);

        // $roles = Role::findOrFail($id);
        
        // $roles->update([
        //     'name'         => $request->input('nama'),
        // ]);


        //ini dari gpt

        $role = Role::findOrFail($id);

        // Validasi input untuk nama role
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,  // Validasi unik, kecuali nama yang sekarang
        ]);
    
        // Update nama role
        $role->update([
            'name' => $request->name,
        ]);
    
        // Jika ada permission yang dipilih, sinkronkan permission
        if ($request->permissions) {
            // Ambil nama permission berdasarkan ID
            $permissions = Permission::whereIn('id', $request->permissions)->get()->pluck('name');
            
            // Sinkronkan permission dengan role
            $role->syncPermissions($permissions);
        } else {
            // Jika tidak ada permission yang dipilih, hapus semua permission
            $role->syncPermissions([]);
        }

        return redirect()->route('role.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function destroy($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        //get product by ID
        // $roles = Role::findOrFail($id);

        // Ambil role berdasarkan ID
        $role = Role::findOrFail($id);

        // Hapus semua permissions yang terhubung dengan role tersebut (opsional jika otomatis dikelola oleh Spatie)
        $role->syncPermissions([]);

        // Hapus role dari database
        $role->delete();

        //delete product
        // $roles->delete();

        //redirect to index
        return redirect()->route('role.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}
