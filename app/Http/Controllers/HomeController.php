<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use DB;
use Cookie;
use App\Models\State;
use App\Models\Lga;
use App\Models\Ward;
use App\Models\PollingUnit;
use App\Models\Party;
use DataTables;
use Validator;
use App\Models\AnnouncedPuResult;



class HomeController extends Controller
{
    public function __construct(){
        $this->states = State::select("state_id", "state_name")->get();
        $this->parties = Party::select("partyid", "partyname")->get();
        $this->units = PollingUnit::select("polling_unit_id", "polling_unit_name")->get();
    }


    function index(){
        $data['page'] = "home";
        $data['states'] = $this->states;
        return view('index', $data);
    }

    function enter_results(){
        $data['page'] = "enter_result";
        $data['states'] = $this->states;
        $data['parties'] = $this->parties;
        $data['polling_units'] = $this->units;
        return view('forms', $data);
    }

    function analysis(){
        $data['page'] = "analysis";
        $data['states'] = $this->states;
        $data['parties'] = $this->parties;
        return view('results', $data);
    }

    
    function enter_score(Request $request){
        $attributes = [
            'party'      => 'Party',
            'unit'       => 'Polling Unit',
            'score'      => 'Score',
            'name'       => 'Names',
        ];
        $rules = [
            'party'      => 'required',
            'unit'       => 'required',
            'score'      => 'required|numeric|gte:0',
            'name'       => 'string'
        ];
        $messages = [
            'required'      => 'The :attribute space is required',
        ];
        $validate=Validator::make($request->all(), $rules, $messages)->setAttributeNames($attributes);
        
        if($validate->fails()){
            return response($validate->errors()->all(), 200);
        }else{
            
            $data = array(
                'polling_unit_uniqueid'     => $request->unit,
                'party_abbreviation'        => $request->party,
                'party_score'               => $request->score,
                'entered_by_user'           => $request->name,
                'user_ip_address'           => $_SERVER['REMOTE_ADDR'],
                'date_entered'              => date("Y-m-d H:i:s", time())
            );
            $insert = AnnouncedPuResult::create($data);

            if($insert){                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Submitted',
                    'data' => ''
                ],200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error in submitting bank details',
                    'data' => ''
                ],200);
            }
        }
    }

    
    function fetch_results(Request $request){
        $state_id = $request->state;
        $lga_id = $request->lga;
        $state_name = strtoupper($request->state_name);
        $state_lga = strtoupper($request->state_lga);

        $results = "";
        $polling_units = PollingUnit::select('polling_unit_id')->where('lga_id', $lga_id)->where('state_id', $state_id)->get();

        $lga_name = Lga::where('lga_id', $lga_id)->value('lga_name');

        if(count($polling_units) > 0){
            foreach($polling_units as $polling_unit){
                $res = AnnouncedPuResult::select('party_abbreviation', 'party_score')->where('polling_unit_uniqueid', $polling_unit->polling_unit_id)->where('party_score', '>', 0)->get();
                
                if(count($res) > 0){
                    $sums=0;
                    foreach($res as $re){
                        $party = $re->party_abbreviation;
                        $party_score = $re->party_score;
                        $sums+=$party_score;
                    }
                }

                // $results .= "<p><b>State:</b> $state_name</p>
                // <p><b>LGA:</b> $lga_name</p>
                // <p><b>Total Score:</b> <font>$polling_unit->total_score</font></p>";
            }
        }else{
            // $results .= "<p><b>State:</b> $state_name</p>
            // <p><b>LGA:</b> $lga_name</p>
            // <p><b>Total Score:</b> <font style='font-size:14px;'>No score computed yet</font></p>";
        }
        


        return response()->json([
            'status' => 'success',
            'message' => 'data retrieved',
            'data' => $polling_units
        ],200);
        

    }


    function display_lgas(Request $request){
        $res = '';
        $state_id = $request->state_id;
        $lgas = Lga::whereState_id($state_id)->orderBy('lga_name', 'asc')->get();
        
        $res .= '<option value="" data-value1="" selected>-Select LGA-</option>';
        if(count($lgas) > 0){
            foreach($lgas as $lga){
                $lga_id = $lga->lga_id;
                $lga_name = ucwords($lga->lga_name);
                $res .= "<option value='$lga_id' data-value1='$lga_name'>$lga_name</option>";
            }
        }else{
            $res .= "";
        }
        return $res;
    }

    function display_wards(Request $request){
        $res = '';
        $lga = $request->lga;
        $wards = Ward::whereLga_id($lga)->orderBy('ward_name', 'asc')->get();
        
        $res .= '<option value="" selected>-Select Ward-</option>';
        if(count($wards) > 0){
            foreach($wards as $ward){
                $ward_id = $ward->ward_id;
                $ward_name = ucwords($ward->ward_name);
                $res .= "<option value='$ward_id' data-value1='$ward_name'>$ward_name</option>";
            }
        }else{
            $res .= "";
        }
        return $res;
    }


    function fetch_ward_details(Request $request){
        $lga_id = $request->lga_id;
        $lga_id = $request->lga_id;

        $datas = PollingUnit::where('lga_id', $request->lga_id)->where('polling_unit_name', $request->lga_name)->orderBy('uniqueid', 'desc')->get();

        $result = "";

        $result .= '<div class="box-body_ mt-0" style="overflow: hidden !important; width:100%">
            <div class="table-responsive project-table">
                <table id="small_tbl" class="table table-striped table-bordered display responsive wrap all_tables1_" cellspacing="0" role="table">
                    <thead role="rowgroup">
                        <tr role="row">
                            <th role="columnheader">Polling Unit No</th>
                            <th role="columnheader">Polling Unit Name</th>
                            <th role="columnheader">Description</th>
                        </tr>
                    </thead>
                    <tbody role="rowgroup">';
                
                        foreach($datas as $data){
                            
                            $polling_unit_number = $data['polling_unit_number'];
                            $polling_unit_name = $data['polling_unit_name'];
                            $entered_by_user = $data['entered_by_user'];
                            $ward_id = $data['ward_id'];
                            $lga_id = $data['lga_id'];
                            
                            $ward_details = Ward::where('ward_id', $ward_id)->orderBy('ward_name', 'asc')->first();
                            
                            $ward_name = $ward_details->ward_name;
                            $ward_description = $ward_details->ward_description;
                            $ward_admin = $ward_details->entered_by_user;

                            $ward_dts = "
                            <b>Ward Name:</b> $ward_name<br>
                            <b>Ward Description:</b> $ward_description<br>
                            <b>Ward Admin:</b> $ward_admin<br>
                            ";
                            
                            $polling_unit_name = ucwords(str_replace('gra', 'GRA', $polling_unit_name));
                            $polling_unit_description = $data['polling_unit_description'];

                            if($polling_unit_description=="") $polling_unit_description="<i style='font-weight: normal !important;'>Not specified</i>";
                            
                            $polling_unit_description = ucwords(str_replace('gra', 'GRA', $polling_unit_description));
                            

                            $result .= "<tr role='row'>
                                <td role='cell'>$polling_unit_number</td>
                                <td role='cell'>".strtoupper($polling_unit_name)." <p class='ward_details'>$ward_dts</p></td>
                                <td role='cell'>$polling_unit_description</td>
                            </tr>";
                        }

        $result .= '</table>
            </div>
        </div>';

        return response()->json([
            'status' => 'success',
            'message' => 'data retrieved',
            'data' => $result
        ],200);
    }


    

    public function display_table_result(Request $request){
        if ($request->ajax()) {

            $data = PollingUnit::whereRaw("state_id = '$request->state' and lga_id = '$request->lga' and ward_id = '$request->ward'")->groupBy('polling_unit_name')->orderBy('polling_unit_id', 'desc');

            return Datatables::of($data)

                ->addColumn('polling_unit_id', function($row){
                    $unit_id = sprintf('%03d', $row->polling_unit_id);
                    return $unit_id;
                })

                ->addColumn('polling_unit_name', function($row){
                    $lga_id = $row->lga_id;
                    $lga_name = $row->polling_unit_name;

                    $counts = PollingUnit::whereState_id($row->state_id)->whereLga_id($row->lga_id)->whereWard_id($row->ward_id)->wherePolling_unit_name($lga_name)->count();

                    $view = "<p class='view_all' lga_name='$lga_name' lga_id='$lga_id' data-toggle='modal' data-target='#modal-center'><a href='javascript:;'>View This Ward</a></p>";

                    $polling_unit_name = strtoupper($row->polling_unit_name)."($counts)";

                    return $polling_unit_name.$view;
                })

                ->addColumn('polling_unit_number', function($row){
                    return $row->polling_unit_number;
                })
                
            ->rawColumns(['polling_unit_id', 'polling_unit_name', 'polling_unit_number'])->make(true);
        }
        
    }




}
