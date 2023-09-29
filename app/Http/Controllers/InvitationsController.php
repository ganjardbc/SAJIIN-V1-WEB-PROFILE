<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Invitation;
use App\Theme;
use App\Song;
use App\Bride;
use App\Event;
use App\Gallery;
use App\Guest;
use App\Comment;
use App\SpecialThanks;
use App\Category;
use Image;

class InvitationsController extends Controller
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
            'user_id' => 'integer'
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
            $status = $req['status'];
            $limit = $req['limit'];
            $offset = $req['offset'];
            $stt = $status ? ['status' => $status] : [];
            $totalRecord = 0;

            if ($uID) 
            {
                $data = Invitation::where($stt)
                    ->where('title', 'LIKE', '%'.$req['search'].'%')
                    ->where(['user_id' => $uID])
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Invitation::where($stt)
                    ->where('title', 'LIKE', '%'.$req['search'].'%')
                    ->where(['user_id' => $uID])
                    ->count();
            } 
            else 
            {
                $data = Invitation::where($stt)
                    ->where('title', 'LIKE', '%'.$req['search'].'%')
                    ->limit($limit)
                    ->offset($offset)
                    ->orderBy('id', 'desc')
                    ->get();
                $totalRecord = Invitation::where($stt)
                    ->where('title', 'LIKE', '%'.$req['search'].'%')
                    ->count();
            }

            if ($data) 
            {
                $newPayload = array();

                $dump = json_decode($data, true);

                for ($i=0; $i < count($dump); $i++) { 
                    $invitation = $dump[$i];
                    $stt = $status ? ['status' => $status] : [];
                    $theme = Theme::where(['id' => $dump[$i]['theme_id']])->first();
                    $song = Song::where(['id' => $dump[$i]['song_id']])->first();
                    $brides = Bride::where(['invitation_id' => $dump[$i]['id']])->get();
                    $category = Category::where(['id' => $dump[$i]['category_id']])->first();
                    $payload = [
                        'invitation' => $invitation,
                        'theme' => $theme,
                        'song' => $song,
                        'brides' => $brides,
                        'category' => $category
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
            'invitation_id' => 'required|string|min:0|max:17',
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
            $invitation_id = $req['invitation_id'];
            $data = Invitation::where(['invitation_id' => $invitation_id])->first();
            
            if ($data) 
            {
                $dump = json_decode($data, true);

                $theme = Theme::where(['id' => $dump['theme_id']])->first();
                $song = Song::where(['id' => $dump['song_id']])->first();
                $brides = Bride::where(['invitation_id' => $dump['id']])->get();
                $category = Category::where(['id' => $dump['category_id']])->first();
                $payload = [
                    'invitation' => $dump,
                    'theme' => $theme,
                    'song' => $song,
                    'brides' => $brides,
                    'category' => $category
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
            'invitation_id' => 'required|string|min:0|max:17',
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
                'cover' => '',
                'updated_by' => Auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $filename = Invitation::where(['invitation_id' => $req['invitation_id']])->first()->cover;
            $data = Invitation::where(['invitation_id' => $req['invitation_id']])->update($payload);

            if ($data)
            {
                unlink(public_path('contents/invitations/thumbnails/'.$filename));
				unlink(public_path('contents/invitations/covers/'.$filename));

                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Invitation::where(['invitation_id' => $req['invitation_id']])->first()
                ];
            }
            else 
            {
                $response = [
                    'message' => 'failed to remove cover',
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
            'invitation_id' => 'required|string|min:0|max:17',
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000000'
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
            $image = $req['cover'];

            $chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
			$filename = $id.time().str_replace($chrc, '', $image->getClientOriginalName());
			$width = getimagesize($image)[0];
			$height = getimagesize($image)[1];

            //save image to server
			//creating thumbnail and save to server
			$destination = public_path('contents/invitations/thumbnails/'.$filename);
			$img = Image::make($image->getRealPath());
			$thumbnail = $img->resize(400, 400, function ($constraint) {
					$constraint->aspectRatio();
				})->save($destination); 

			//saving image real to server
			$destination = public_path('contents/invitations/covers/');
			$real = $image->move($destination, $filename);

            if ($thumbnail && $real) 
			{
                $payload = [
                    'cover' => $filename,
                    'updated_by' => Auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
    
                $data = Invitation::where(['invitation_id' => $req['invitation_id']])->update($payload);
    
                if ($data)
                {
                    $response = [
                        'message' => 'proceed success',
                        'status' => 'ok',
                        'code' => '201',
                        'data' => Invitation::where(['invitation_id' => $req['invitation_id']])->first()
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
            'invitation_id' => 'required|string|min:0|max:17|unique:invitations',
            'short_link' => 'required|string|min:0|max:64|unique:invitations',
            'title' => 'required|string',
            'day' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|string',
            'type' => 'required|string',
            'is_available' => 'required|boolean',
            'theme_id' => 'required|integer',
            'song_id' => 'required|integer',
            'category_id' => 'required|integer',
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
                'invitation_id' => $req['invitation_id'],
                'short_link' => $req['short_link'],
                'title' => $req['title'],
                'description' => $req['description'],
                'video' => $req['video'],
                'video_link' => $req['video_link'],
                'day' => $req['day'],
                'date' => $req['date'],
                'time' => $req['time'],
                'time_zone' => $req['time_zone'],
                'latitude' => $req['latitude'],
                'longitude' => $req['longitude'],
                'tag' => $req['tag'],
                'note' => $req['note'],
                'type' => $req['type'],
                'status' => $req['status'],
                'is_available' => $req['is_available'],
                'is_free_trial' => $req['is_free_trial'],
                'is_reservation_enable' => $req['is_reservation_enable'],
                'theme_id' => $req['theme_id'],
                'song_id' => $req['song_id'],
                'category_id' => $req['category_id'],
                'price' => $req['price'],
                'discount' => $req['discount'],
                'total_price' => $req['total_price'],
                'payment_status' => $req['payment_status'],
                'user_id' => Auth()->user()->id,
                'created_by' => Auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $data = Invitation::insert($payload);

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Invitation::where(['invitation_id' => $req['invitation_id']])->first()
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
            'invitation_id' => 'required|string|min:0|max:17',
            'short_link' => 'required|string|min:0|max:64',
            'title' => 'required|string',
            'day' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|string',
            'type' => 'required|string',
            'is_available' => 'required|boolean',
            'theme_id' => 'required|integer',
            'song_id' => 'required|integer',
            'category_id' => 'required|integer',
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
                'short_link' => $req['short_link'],
                'title' => $req['title'],
                'description' => $req['description'],
                'video' => $req['video'],
                'video_link' => $req['video_link'],
                'day' => $req['day'],
                'date' => $req['date'],
                'time' => $req['time'],
                'time_zone' => $req['time_zone'],
                'latitude' => $req['latitude'],
                'longitude' => $req['longitude'],
                'tag' => $req['tag'],
                'note' => $req['note'],
                'type' => $req['type'],
                'status' => $req['status'],
                'is_available' => $req['is_available'],
                'is_free_trial' => $req['is_free_trial'],
                'is_reservation_enable' => $req['is_reservation_enable'],
                'theme_id' => $req['theme_id'],
                'song_id' => $req['song_id'],
                'category_id' => $req['category_id'],
                'price' => $req['price'],
                'discount' => $req['discount'],
                'total_price' => $req['total_price'],
                'payment_status' => $req['payment_status'],
                'updated_by' => Auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($req['user_id']) {
                $payload['user_id'] = $req['user_id'];
            }

            $data = Invitation::where(['invitation_id' => $req['invitation_id']])->update($payload);

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Invitation::where(['invitation_id' => $req['invitation_id']])->first()
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
            'invitation_id' => 'required|string|min:0|max:17',
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
            $invitation = Invitation::where(['invitation_id' => $req['invitation_id']])->first();

            try {
                Bride::where(['invitation_id' => $invitation->id])->delete();
                Event::where(['invitation_id' => $invitation->id])->delete();
                Gallery::where(['invitation_id' => $invitation->id])->delete();
                Guest::where(['invitation_id' => $invitation->id])->delete();
                Comment::where(['invitation_id' => $invitation->id])->delete();
                SpecialThanks::where(['invitation_id' => $invitation->id])->delete();
                Invitation::where(['id' => $invitation->id])->delete();

                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => [$invitation]
                ];
            } catch (\Throwable $th) {
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
