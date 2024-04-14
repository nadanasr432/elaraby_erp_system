<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Bondclient;
use App\Models\Bondsupplier;
use App\Models\Supplier;
use App\Models\OuterClient;
use App\Models\ElectronicStamps;
use File;


class BondsController extends Controller
{
    public function getClientsBonds()
    {
        $bondClients = Bondclient::where("company_id", Auth::user()->company_id)->latest()->get();
        return view('client.clients_bonds.index',compact("bondClients"));
    }
    //show create page..
    public function createClientsBonds()
    {
        //get company..
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        //get all clients..
        if(in_array('مدير النظام',Auth::user()->role_name)){
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        }
        else{
            $outer_clients = OuterClient::where('company_id', $company_id)
            ->where(function ($query) {
                $query->where('client_id',Auth::user()->id)
                ->orWhereNull('client_id');
            })->get();
        }


        return view('client.clients_bonds.create',compact("outer_clients"));
    }

    //store new clientBond...
    public function storeNewBond(Request $request){

        $company_id = Auth::user()->company_id;

        //get client from outClietns table...
        $OuterClient = OuterClient::where("client_name", $request->client)->where('company_id', $company_id)->get()->first();

        if($request->type == "قبض"){
            $OuterClient->prev_balance -= $request->amount;
        }else{
            $OuterClient->prev_balance += $request->amount;
        }
        $OuterClient->save();

        try{
            $bond = Bondclient::create([
                "company_id"=>$request->company_id,
                "client"=>$request->client,
                "account"=>$request->account,
                "type"=>$request->type,
                "date"=>$request->date,
                "amount"=>$request->amount,
                "notes"=>$request->notes
            ]);
        }catch(Exception $e){
            return json_encode($e->getMessage());
        }
        return json_encode($bond->id);
    }

    public function deleteClientBond(Request $request)
    {
        Bondclient::destroy($request->client_bond_id);
        return redirect("ar/client/clients-bonds/index");
    }

    public function getClientBond($id){

        //get company..
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        //get all clients..
        if(in_array('مدير النظام',Auth::user()->role_name)){
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        }
        else{
            $outer_clients = OuterClient::where('company_id', $company_id)
            ->where(function ($query) {
                $query->where('client_id',Auth::user()->id)
                ->orWhereNull('client_id');
            })->get();
        }


        $clientBond = Bondclient::find($id);
        return view('client.clients_bonds.edit',compact("clientBond","outer_clients"));
    }

    public function updateClientBond(Request $request){
       $clientBond = Bondclient::find($request->client_bond_id);
       $clientBond->client = $request->client;
       $clientBond->account = $request->account;
       $clientBond->type = $request->type;
       $clientBond->date = $request->date;
       $clientBond->amount = $request->amount;
       $clientBond->notes = $request->notes;
       if($clientBond->save()){
            return json_encode(1);
       }else{
           return json_encode("err");
       }

    }

    //index page for supliers bonds..
    public function getSuppliersBonds()
    {
        $blondSuppliers = Bondsupplier::where("company_id", Auth::user()->company_id)->latest()->get();
        return view('client.suppliers_bonds.index', compact("blondSuppliers"));
    }

    //create page for supliers bonds..
    public function createSuppliersBonds()
    {
        $suppliers = Supplier::where("company_id", Auth::user()->company_id)->get();
        return view('client.suppliers_bonds.create', compact("suppliers"));
    }

    //store new supplierBond...
    public function storeNewBondSupplier(Request $request){

        $company_id = Auth::user()->company_id;

        //get client from outClietns table...
        $supplier = Supplier::where("supplier_name", $request->supplier)->where('company_id', $company_id)->get()->first();

        if($request->type == "قبض"){
            $supplier->prev_balance -= $request->amount;
        }else{
            $supplier->prev_balance += $request->amount;
        }
        $supplier->save();



        try{
            $bond = Bondsupplier::create([
                "company_id"=>$request->company_id,
                "supplier"=>$request->supplier,
                "account"=>$request->account,
                "type"=>$request->type,
                "date"=>$request->date,
                "amount"=>$request->amount,
                "notes"=>$request->notes
            ]);
        }catch(Exception $e){
            return json_encode($e->getMessage());
        }
        return json_encode($bond->id);
    }

    public function showClientBondPrint($clientid){
        //get company_id..
        $company_id = Auth::user()->company_id;
        $company_data = Company::where("id" , $company_id)->get()[0];
        $clientBond = Bondclient::find($clientid);
        $electronicStamp = ElectronicStamps::where('company_id',Auth::user()->company_id)->first();
        return view('client.clients_bonds.show',compact("clientBond",'company_data','electronicStamp'));
    }
    public function getSupplierBond($supplierid){

        //get company..
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        //get all suppliers according to company_id..
        $suppliers = Supplier::where("company_id", Auth::user()->company_id)->get();

        $supplierBond = Bondsupplier::find($supplierid);
        return view('client.suppliers_bonds.edit',compact("supplierBond","suppliers"));
    }

    public function updateSupplierBond(Request $request){
       $supplierBond = Bondsupplier::find($request->supplier_bond_id);
       $supplierBond->supplier = $request->supplier;
       $supplierBond->account = $request->account;
       $supplierBond->type = $request->type;
       $supplierBond->date = $request->date;
       $supplierBond->amount = $request->amount;
       $supplierBond->notes = $request->notes;
       if($supplierBond->save()){
            return json_encode(1);
       }else{
           return json_encode("err");
       }

    }

    public function deleteSupplierBond(Request $request)
    {
        Bondsupplier::destroy($request->supplierID);
        return redirect("ar/client/suppliers-bonds/index");
    }

    public function showSupplierBondPrint($supplierid){
        $electronicStamp = ElectronicStamps::where('company_id',Auth::user()->company_id)->first();
        $supplierBond = Bondsupplier::find($supplierid);
        $company_data = Company::where("id" , Auth::user()->company_id)->get()[0];

        return view('client.suppliers_bonds.show',compact("supplierBond",'electronicStamp','company_data'));
    }



    public function electronicStmapPage(){
        $electronicStamp = ElectronicStamps::where('company_id',Auth::user()->company_id)->first();
        return view('client.electronic_stamp',compact('electronicStamp'));
    }

    public function addElectronicStamp(Request $request){

        $electronicStamp = ElectronicStamps::where('company_id',Auth::user()->company_id)->first();


        $img = $_FILES['elec_stamp'];
        $imgName = time(). "." . strtolower(explode(".", $img['name'])[1]);
        $path = base_path("assets/images/electronic_stamps/" . $imgName);


        if(move_uploaded_file($img['tmp_name'], $path)){

            //check if there is an stamp already uploaded
            if($electronicStamp !== null ){

                //yes there is an stamp uploaded... so we need to delete it.
                $img_path = base_path("assets/images/electronic_stamps/".$electronicStamp->img);
                if(File::exists($img_path)) {
                    File::delete($img_path);
                }

                $electronicStamp->img = $imgName;
                $electronicStamp->save();
            }else{
                $electronicStamp = new ElectronicStamps();
                $electronicStamp->img = $imgName;
                $electronicStamp->company_id = Auth::user()->company_id;
                $electronicStamp->save();
            }
            echo $imgName;
        }else{
            echo "err";
        }

    }



}
