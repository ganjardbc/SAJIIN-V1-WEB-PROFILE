<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Gallery;
use App\Invitation;
use Image;

class GalleryController extends Controller
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
            $type = $req['type'] ? ['type' => $req['type']] : [];
            $totalRecord = 0;

            if ($uID) 
            {
                $data = Gallery::where($status)
                    ->where('description', 'LIKE', '%'.$req['search'].'%')
                    ->where($type)
                    ->where(['created_by' => $uID])
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Gallery::where($status)
                    ->where('description', 'LIKE', '%'.$req['search'].'%')
                    ->where($type)
                    ->where(['created_by' => $uID])
                    ->count();
            } 
            else if ($invitationId) {
                $invitation = Invitation::where(['invitation_id' => $invitationId])->first();
                $data = Gallery::where($status)
                    ->where('description', 'LIKE', '%'.$req['search'].'%')
                    ->where($type)
                    ->where(['invitation_id' => $invitation->id])
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Gallery::where($status)
                    ->where('description', 'LIKE', '%'.$req['search'].'%')
                    ->where($type)
                    ->where(['invitation_id' => $invitation->id])
                    ->count();
            }
            else 
            {
                $data = Gallery::where($status)
                    ->where('description', 'LIKE', '%'.$req['search'].'%')
                    ->where($type)
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Gallery::where($status)
                    ->where('description', 'LIKE', '%'.$req['search'].'%')
                    ->where($type)
                    ->count();
            }
            
            if ($data) 
            {
                $newPayload = array();

                $dump = json_decode($data, true);

                for ($i=0; $i < count($dump); $i++) { 
                    $gallery = $dump[$i];
                    $stt = $status ? ['status' => $status] : [];
                    $invitation = Invitation::where(['id' => $dump[$i]['invitation_id']])->orderBy('id', 'desc')->first();
                    $payload = [
                        'gallery' => $gallery,
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
            'gallery_id' => 'required|string|min:0|max:17',
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
            $gallery_id = $req['gallery_id'];
            $data = Gallery::where(['gallery_id' => $gallery_id])->first();
            
            if ($data) 
            {
                $dump = json_decode($data, true);

                $invitation = Invitation::where(['id' => $dump['invitation_id']])->orderBy('id', 'desc')->first();
                $payload = [
                    'gallery' => $dump,
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
            'gallery_id' => 'required|string|min:0|max:17',
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

            $filename = Gallery::where(['gallery_id' => $req['gallery_id']])->first()->image;
            $data = Gallery::where(['gallery_id' => $req['gallery_id']])->update($payload);

            if ($data)
            {
                unlink(public_path('contents/galleries/thumbnails/'.$filename));
				unlink(public_path('contents/galleries/covers/'.$filename));

                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Gallery::where(['gallery_id' => $req['gallery_id']])->first()
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
            'gallery_id' => 'required|string|min:0|max:17',
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
            $id = $req['gallery_id'];
            $image = $req['image'];

            $chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
			$filename = $id.time().str_replace($chrc, '', $image->getClientOriginalName());
			$width = getimagesize($image)[0];
			$height = getimagesize($image)[1];

            //save image to server
			//creating thumbnail and save to server
			$destination = public_path('contents/galleries/thumbnails/'.$filename);
			$img = Image::make($image->getRealPath());
			$thumbnail = $img->resize(400, 400, function ($constraint) {
					$constraint->aspectRatio();
				})->save($destination); 

			//saving image real to server
			$destination = public_path('contents/galleries/covers/');
			$real = $image->move($destination, $filename);

            if ($thumbnail && $real) 
			{
                $payload = [
                    'image' => $filename,
                    'updated_by' => Auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
    
                $data = Gallery::where(['gallery_id' => $req['gallery_id']])->update($payload);
    
                if ($data)
                {
                    $response = [
                        'message' => 'proceed success',
                        'status' => 'ok',
                        'code' => '201',
                        'data' => Gallery::where(['gallery_id' => $req['gallery_id']])->first()
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

    public function post(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'gallery_id' => 'required|string|min:0|max:17|unique:galleries',
            'description' => 'required|string',
            'type' => 'required|string',
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
                'gallery_id' => $req['gallery_id'],
                'description' => $req['description'],
                'tag' => $req['tag'],
                'type' => $req['type'],
                'status' => $req['status'],
                'is_available' => $req['is_available'],
                'invitation_id' => $req['invitation_id'],
                'created_by' => Auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $data = Gallery::insert($payload);

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Gallery::where(['gallery_id' => $req['gallery_id']])->first()
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
            'gallery_id' => 'required|string|min:0|max:17',
            'description' => 'required|string',
            'type' => 'required|string',
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
                'description' => $req['description'],
                'tag' => $req['tag'],
                'type' => $req['type'],
                'status' => $req['status'],
                'is_available' => $req['is_available'],
                'invitation_id' => $req['invitation_id'],
                'updated_by' => Auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $data = Gallery::where(['gallery_id' => $req['gallery_id']])->update($payload);

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Gallery::where(['gallery_id' => $req['gallery_id']])->first()
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
            'gallery_id' => 'required|string|min:0|max:17',
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
            $data = Gallery::where(['gallery_id' => $req['gallery_id']])->delete();

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
