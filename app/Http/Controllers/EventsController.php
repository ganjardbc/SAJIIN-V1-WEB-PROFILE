<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Event;
use App\Invitation;
use Image;

class EventsController extends Controller
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
            $status = $req['status'];
            $limit = $req['limit'];
            $offset = $req['offset'];
            $stt = $status ? ['status' => $status] : [];
            $totalRecord = 0;

            if ($uID) 
            {
                $data = Event::where($stt)
                    ->where('title', 'LIKE', '%'.$req['search'].'%')
                    ->where(['created_by' => $uID])
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Event::where($stt)
                    ->where('title', 'LIKE', '%'.$req['search'].'%')
                    ->where(['created_by' => $uID])
                    ->count();
            } 
            else if ($invitationId) {
                $invitation = Invitation::where(['invitation_id' => $invitationId])->first();
                $data = Event::where($stt)
                    ->where('title', 'LIKE', '%'.$req['search'].'%')
                    ->where(['invitation_id' => $invitation->id])
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Event::where($stt)
                    ->where('title', 'LIKE', '%'.$req['search'].'%')
                    ->where(['invitation_id' => $invitation->id])
                    ->count();
            }
            else 
            {
                $data = Event::where($stt)
                    ->where('title', 'LIKE', '%'.$req['search'].'%')
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Event::where($stt)
                    ->where('title', 'LIKE', '%'.$req['search'].'%')
                    ->count();
            }

            if ($data) 
            {
                $newPayload = array();

                $dump = json_decode($data, true);

                for ($i=0; $i < count($dump); $i++) { 
                    $event = $dump[$i];
                    $stt = $status ? ['status' => $status] : [];
                    $invitation = Invitation::where(['id' => $dump[$i]['invitation_id']])->orderBy('id', 'desc')->first();
                    $payload = [
                        'event' => $event,
                        'invitation' => $invitation
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

    public function getByID(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'event_id' => 'required|string|min:0|max:17',
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
            $event_id = $req['event_id'];
            $data = Event::where(['event_id' => $event_id])->first();
            
            if ($data) 
            {
                $dump = json_decode($data, true);

                $invitation = Invitation::where(['id' => $dump['invitation_id']])->orderBy('id', 'desc')->first();
                $payload = [
                    'event' => $dump,
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
            'event_id' => 'required|string|min:0|max:17',
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

            $filename = Event::where(['event_id' => $req['event_id']])->first()->image;
            $data = Event::where(['event_id' => $req['event_id']])->update($payload);

            if ($data)
            {
                unlink(public_path('contents/events/thumbnails/'.$filename));
				unlink(public_path('contents/events/covers/'.$filename));

                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Event::where(['event_id' => $req['event_id']])->first()
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
            'event_id' => 'required|string|min:0|max:17',
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
            $id = $req['event_id'];
            $image = $req['image'];

            $chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
			$filename = $id.time().str_replace($chrc, '', $image->getClientOriginalName());
			$width = getimagesize($image)[0];
			$height = getimagesize($image)[1];

            //save image to server
			//creating thumbnail and save to server
			$destination = public_path('contents/events/thumbnails/'.$filename);
			$img = Image::make($image->getRealPath());
			$thumbnail = $img->resize(400, 400, function ($constraint) {
					$constraint->aspectRatio();
				})->save($destination); 

			//saving image real to server
			$destination = public_path('contents/events/covers/');
			$real = $image->move($destination, $filename);

            if ($thumbnail && $real) 
			{
                $payload = [
                    'image' => $filename,
                    'updated_by' => Auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
    
                $data = Event::where(['event_id' => $req['event_id']])->update($payload);
    
                if ($data)
                {
                    $response = [
                        'message' => 'proceed success',
                        'status' => 'ok',
                        'code' => '201',
                        'data' => Event::where(['event_id' => $req['event_id']])->first()
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
                    'message' => 'failed to upload cover',
                    'status' => 'failed',
                    'code' => '201',
                    'data' => []
                ];
            }
        }

        return response()->json($response, 200);
    }

    public function post(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'event_id' => 'required|string|min:0|max:17|unique:events',
            'title' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|string',
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
                'event_id' => $req['event_id'],
                'title' => $req['title'],
                'description' => $req['description'],
                'day' => $req['day'],
                'date' => $req['date'],
                'date' => $req['date'],
                'time' => $req['time'],
                'time_zone' => $req['time_zone'],
                'address' => $req['address'],
                'streaming_link' => $req['streaming_link'],
                'status' => $req['status'],
                'is_available' => $req['is_available'],
                'invitation_id' => $req['invitation_id'],
                'created_by' => Auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $data = Event::insert($payload);

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Event::where(['event_id' => $req['event_id']])->first()
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
            'event_id' => 'required|string|min:0|max:17',
            'title' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|string',
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
                'title' => $req['title'],
                'description' => $req['description'],
                'day' => $req['day'],
                'date' => $req['date'],
                'date' => $req['date'],
                'time' => $req['time'],
                'time_zone' => $req['time_zone'],
                'address' => $req['address'],
                'streaming_link' => $req['streaming_link'],
                'status' => $req['status'],
                'is_available' => $req['is_available'],
                'invitation_id' => $req['invitation_id'],
                'updated_by' => Auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $data = Event::where(['event_id' => $req['event_id']])->update($payload);

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Event::where(['event_id' => $req['event_id']])->first()
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
            'event_id' => 'required|string|min:0|max:17',
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
            $data = Event::where(['event_id' => $req['event_id']])->delete();

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
