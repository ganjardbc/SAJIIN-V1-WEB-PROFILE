<?php

namespace App\Http\Controllers;

use App\Imports\GuestsImport;
use App\Exports\GuestsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Guest;
use App\Invitation;
use App\Bride;
use Image;

class GuestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function getAll(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'limit' => 'required|integer',
            'offset' => 'required|integer',
            'status' => 'string',
            'user_id' => 'integer',
            'invitation_id' => 'string'
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $uID = $req['user_id'];
            $invitationId = $req['invitation_id'];
            $limit = $req['limit'];
            $offset = $req['offset'];
            $status = $req['status'] ? ['status' => $req['status']] : [];
            $isPresent = $req['present_type'] ? ['present_type' => $req['present_type']] : [];
            $totalRecord = 0;
            $newStatus = $status;

            if ($req['bride_id']) {
                $newStatus = array_merge($newStatus, ['bride_id' => $req['bride_id']]);
            }

            if ($uID) 
            {
                $data = Guest::where($newStatus)
                    ->where('name', 'LIKE', '%'.$req['search'].'%')
                    ->where($isPresent)
                    ->where(['created_by' => $uID])
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Guest::where($newStatus)    
                    ->where('name', 'LIKE', '%'.$req['search'].'%')
                    ->where($isPresent)
                    ->where(['created_by' => $uID])
                    ->count();
            } 
            else if ($invitationId) {
                $invitation = Invitation::where(['invitation_id' => $invitationId])->first();
                $data = Guest::where($newStatus)
                    ->where('name', 'LIKE', '%'.$req['search'].'%')
                    ->where($isPresent)
                    ->where(['invitation_id' => $invitation->id])
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Guest::where($newStatus)
                    ->where('name', 'LIKE', '%'.$req['search'].'%')
                    ->where($isPresent)
                    ->where(['invitation_id' => $invitation->id])
                    ->count();
            }
            else 
            {
                $data = Guest::where($newStatus)
                    ->where('name', 'LIKE', '%'.$req['search'].'%')
                    ->where($isPresent)
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Guest::where($newStatus)
                    ->where('name', 'LIKE', '%'.$req['search'].'%')
                    ->where($isPresent)
                    ->count();
            }

            if ($data) 
            {
                $newPayload = array();

                $dump = json_decode($data, true);

                for ($i=0; $i < count($dump); $i++) { 
                    $guest = $dump[$i];
                    $stt = $status ? ['status' => $status] : [];
                    $invitation = Invitation::where(['id' => $dump[$i]['invitation_id']])->orderBy('id', 'desc')->first();
                    $brides = Bride::where(['invitation_id' => $dump[$i]['invitation_id']])->get();
                    $payload = [
                        'guest' => $guest,
                        'invitation' => $invitation,
                        'brides' => $brides
                    ];
                    array_push($newPayload, $payload);
                }

                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => $newPayload,
                    'total_record' => $totalRecord
                ];
            } 
            else 
            {
                $response = [
                    'message' => 'failed to get datas',
                    'status' => 'failed',
                    'code' => '201',
                    'data' => [],
                    'total_record' => $totalRecord
                ];
            }
        }

        return response()->json($response, 200);
    }

    public function getQuantity(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'limit' => 'required|integer',
            'offset' => 'required|integer',
            'status' => 'string',
            'user_id' => 'integer',
            'invitation_id' => 'string'
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $uID = $req['user_id'];
            $invitationId = $req['invitation_id'];
            $limit = $req['limit'];
            $offset = $req['offset'];
            $status = $req['status'] ? ['status' => $req['status']] : [];
            $totalPresent = 0;
            $totalWillPresent = 0;
            $totalNotPresent = 0;
            $totalWaitingResponse = 0;

            if ($uID) 
            {
                $totalPresent = Guest::where($status)    
                    ->where(['present_type' => 'present'])
                    ->where(['created_by' => $uID])
                    ->sum('attendance');
                $totalWillPresent = Guest::where($status)    
                    ->where(['present_type' => 'will-present'])
                    ->where(['created_by' => $uID])
                    ->sum('attendance');
                $totalNotPresent = Guest::where($status)    
                    ->where(['present_type' => 'not-present'])
                    ->where(['created_by' => $uID])
                    ->count();
                $totalWaitingResponse = Guest::where($status)    
                    ->where(['present_type' => 'waiting-response'])
                    ->where(['created_by' => $uID])
                    ->count();
            } 
            else if ($invitationId) {
                $invitation = Invitation::where(['invitation_id' => $invitationId])->first();
                $totalPresent = Guest::where($status)    
                    ->where(['present_type' => 'present'])
                    ->where(['invitation_id' => $invitation->id])
                    ->sum('attendance');
                $totalWillPresent = Guest::where($status)    
                    ->where(['present_type' => 'will-present'])
                    ->where(['invitation_id' => $invitation->id])
                    ->sum('attendance');
                $totalNotPresent = Guest::where($status)    
                    ->where(['present_type' => 'not-present'])
                    ->where(['invitation_id' => $invitation->id])
                    ->count();
                $totalWaitingResponse = Guest::where($status)    
                    ->where(['present_type' => 'waiting-response'])
                    ->where(['invitation_id' => $invitation->id])
                    ->count();
            }
            else 
            {
                $totalPresent = Guest::where($status)    
                    ->where(['present_type' => 'present'])
                    ->sum('attendance');
                $totalWillPresent = Guest::where($status)    
                    ->where(['present_type' => 'will-present'])
                    ->sum('attendance');
                $totalNotPresent = Guest::where($status)    
                    ->where(['present_type' => 'not-present'])
                    ->count();
                $totalWaitingResponse = Guest::where($status)    
                    ->where(['present_type' => 'waiting-response'])
                    ->count();
            }

            $response = [
                'message' => 'proceed success',
                'status' => 'ok',
                'code' => '201',
                'data' => [
                    'total_present' => $totalPresent,
                    'total_will_present' => $totalWillPresent,
                    'total_not_present' => $totalNotPresent,
                    'total_waiting_response' => $totalWaitingResponse,
                ]
            ];
        }

        return response()->json($response, 200);
    }

    public function getByID(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'guest_id' => 'required|string|min:0',
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $guest_id = $req['guest_id'];
            $data = Guest::where(['guest_id' => $guest_id])->first();
            
            if ($data) 
            {
                $dump = json_decode($data, true);

                $invitation = Invitation::where(['id' => $dump['invitation_id']])->orderBy('id', 'desc')->first();
                $brides = Bride::where(['invitation_id' => $dump['invitation_id']])->get();
                $payload = [
                    'guest' => $dump,
                    'invitation' => $invitation
                ];

                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => $payload
                ];
            } 
            else 
            {
                $response = [
                    'message' => 'failed to get datas',
                    'status' => 'failed',
                    'code' => '201',
                    'data' => []
                ];
            }
        }

        return response()->json($response, 200);
    }

    public function removeImage(Request $req) 
    {
        $validator = Validator::make($req->all(), [
            'guest_id' => 'required|string|min:0',
        ]);
        
        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $payload = [
                'image' => '',
                'updated_by' => Auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $filename = Guest::where(['guest_id' => $req['guest_id']])->first()->image;
            $data = Guest::where(['guest_id' => $req['guest_id']])->update($payload);

            if ($data)
            {
                unlink(public_path('contents/guests/thumbnails/'.$filename));
				unlink(public_path('contents/guests/covers/'.$filename));

                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Guest::where(['guest_id' => $req['guest_id']])->first()
                ];
            }
            else 
            {
                $response = [
                    'message' => 'failed to remove image',
                    'status' => 'failed',
                    'code' => '201',
                    'data' => []
                ];
            }
        }
    }

    public function uploadImage(Request $req) 
    {
        $validator = Validator::make($req->all(), [
            'guest_id' => 'required|string|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1000000'
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $id = $req['guest_id'];
            $image = $req['image'];

            $chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
			$filename = $id.time().str_replace($chrc, '', $image->getClientOriginalName());
			$width = getimagesize($image)[0];
			$height = getimagesize($image)[1];

            //save image to server
			//creating thumbnail and save to server
			$destination = public_path('contents/guests/thumbnails/'.$filename);
			$img = Image::make($image->getRealPath());
			$thumbnail = $img->resize(400, 400, function ($constraint) {
					$constraint->aspectRatio();
				})->save($destination); 

			//saving image real to server
			$destination = public_path('contents/guests/covers/');
			$real = $image->move($destination, $filename);

            if ($thumbnail && $real) 
			{
                $payload = [
                    'image' => $filename,
                    'updated_by' => Auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
    
                $data = Guest::where(['guest_id' => $req['guest_id']])->update($payload);
    
                if ($data)
                {
                    $response = [
                        'message' => 'proceed success',
                        'status' => 'ok',
                        'code' => '201',
                        'data' => Guest::where(['guest_id' => $req['guest_id']])->first()
                    ];
                }
                else 
                {
                    $response = [
                        'message' => 'failed to save',
                        'status' => 'failed',
                        'code' => '201',
                        'data' => []
                    ];
                }
            }
            else 
            {
                $response = [
                    'message' => 'failed to upload image',
                    'status' => 'failed',
                    'code' => '201',
                    'data' => []
                ];
            }
        }

        return response()->json($response, 200);
    }

    public function bulkDownload(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'invitation_id' => 'required|string|min:0|max:17'
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $id = $req['invitation_id'];
            $data = Guest::where(['invitation_id' => $id])->get();
            $invitation = Invitation::where(['id' => $id])->first();
            $payload = array();

            foreach ($data as $item) {
                array_push($payload, [
                    $item->name,
                    $item->phone,
                    $item->address,
                    $item->rsvp,
                    $item->is_present == 1 ? 'Hadir' : 'Tidak Hadir',
                    'https://undangabi.com/'.$invitation->short_link.'?kepada='.str_replace(' ', '%20', $item->name)
                ]);
            }

            $response = [
                'message' => 'proceed success',
                'status' => 'ok',
                'code' => '201',
                'data' => $payload
            ];
        }

        return response()->json($response, 200);
    }

    public function bulkUpload(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'invitation_id' => 'required|string|min:0|max:17',
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $id = $req['invitation_id'];
            $brideId = $req['bride_id'];
            $file = $req['file'];

            $importData_arr = array();
            $data = Excel::toArray(new GuestsImport, $file);
            $raw_data = $data[0];

            for ($i=0; $i < count($raw_data); $i++) { 
                # code...
                if ($i != 0) {
                    $importData_arr[$i] = $payload = [
                        'guest_id' => "GE-" . $id . "-" . rand(000000000000,999999999999),
                        'name' => $raw_data[$i][0],
                        'phone' => null,
                        'address' => $raw_data[$i][1],
                        'comments' => null,
                        'rsvp' => $raw_data[$i][2],
                        'present_type' => 'waiting-response',
                        'is_present' => null,
                        'status' => 'active',
                        'is_available' => 1,
                        'invitation_id' => $id,
                        'bride_id' => $brideId,
                        'created_by' => Auth()->user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth()->user()->id,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    Guest::insert($payload);
                }
            }

            $response = [
                'message' => 'proceed success',
                'status' => 'ok',
                'code' => '201',
                'data' => $importData_arr
            ];
        }

        return response()->json($response, 200);
    }

    public function post(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'guest_id' => 'required|string|min:0|unique:guests',
            'name' => 'required|string',
            'status' => 'required|string',
            'present_type' => 'required|string',
            'is_available' => 'required|boolean',
            'invitation_id' => 'required|integer'
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $payload = [
                'guest_id' => $req['guest_id'],
                'name' => $req['name'],
                'phone' => $req['phone'],
                'address' => $req['address'],
                'comments' => $req['comments'],
                'attendance' => $req['attendance'],
                'rsvp' => $req['rsvp'],
                'is_present' => $req['is_present'],
                'present_type' => $req['present_type'],
                'status' => $req['status'],
                'is_available' => $req['is_available'],
                'invitation_id' => $req['invitation_id'],
                'bride_id' => $req['bride_id'],
                'created_by' => Auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $data = Guest::insert($payload);

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Guest::where(['guest_id' => $req['guest_id']])->first()
                ];
            }
            else 
            {
                $response = [
                    'message' => 'failed to save',
                    'status' => 'failed',
                    'code' => '201',
                    'data' => []
                ];
            }
        }

        return response()->json($response, 200);
    }

    public function update(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'guest_id' => 'required|string|min:0',
            'name' => 'required|string',
            'status' => 'required|string',
            'present_type' => 'required|string',
            'is_available' => 'required|boolean',
            'invitation_id' => 'required|integer'
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $payload = [
                'name' => $req['name'],
                'phone' => $req['phone'],
                'address' => $req['address'],
                'comments' => $req['comments'],
                'attendance' => $req['attendance'],
                'rsvp' => $req['rsvp'],
                'is_present' => $req['is_present'],
                'present_type' => $req['present_type'],
                'status' => $req['status'],
                'is_available' => $req['is_available'],
                'invitation_id' => $req['invitation_id'],
                'bride_id' => $req['bride_id'],
                'updated_by' => Auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $data = Guest::where(['guest_id' => $req['guest_id']])->update($payload);

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Guest::where(['guest_id' => $req['guest_id']])->first()
                ];
            }
            else 
            {
                $response = [
                    'message' => 'failed to save',
                    'status' => 'failed',
                    'code' => '201',
                    'data' => []
                ];
            }
        }

        return response()->json($response, 200);
    }

    public function delete(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'guest_id' => 'required|string',
        ]);

        $response = [];

        if ($validator->fails()) 
        {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } 
        else 
        {
            $data = Guest::where(['guest_id' => $req['guest_id']])->delete();

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => []
                ];
            }
            else 
            {
                $response = [
                    'message' => 'failed to delete',
                    'status' => 'failed',
                    'code' => '201',
                    'data' => []
                ];
            }
        }

        return response()->json($response, 200);
    }
}
