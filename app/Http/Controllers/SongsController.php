<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Song;
use Image;

class SongsController extends Controller
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
            'status' => 'string'
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
            $status = $req['status'];
            $limit = $req['limit'];
            $offset = $req['offset'];
            $stt = $status ? ['status' => $status] : [];
            $total_record = 0;

            $data = Song::where($stt)->limit($limit)->offset($offset)->orderBy('id', 'desc')->get();
            $total_record = Song::where($stt)->count('id');

            if ($data) 
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => $data,
                    'total_record' => $total_record
                ];
            } 
            else 
            {
                $response = [
                    'message' => 'failed to get datas',
                    'status' => 'failed',
                    'code' => '201',
                    'data' => [],
                    'total_record' => $total_record
                ];
            }
        }

        return response()->json($response, 200);
    }

    public function getByID(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'song_id' => 'required|string|min:0|max:17',
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
            $song_id = $req['song_id'];
            $data = Song::where(['song_id' => $song_id])->first();
            
            if ($data) 
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => $data
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
            'song_id' => 'required|string|min:0|max:17',
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
                'song' => '',
                'updated_by' => Auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $filename = Song::where(['song_id' => $req['song_id']])->first()->song;
            $data = Song::where(['song_id' => $req['song_id']])->update($payload);

            if ($data)
            {
                unlink(public_path('contents/songs/'.$filename));

                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Song::where(['song_id' => $req['song_id']])->first()
                ];
            }
            else 
            {
                $response = [
                    'message' => 'failed to remove song',
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
            'song_id' => 'required|string|min:0|max:17',
            'song' => 'required|file|mimes:audio/mpeg,mpga,mp3,wav,aac'
        ]);

        $response = [];

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'status' => 'invalide',
                'code' => '201',
                'data' => []
            ];
        } else {
            $id = $req['song_id'];
            $song = $req['song'];

            if ($req->hasFile('song')) {
                $original_name = $req->file('song')->getClientOriginalName();
                $size = $req->file('song')->getSize();
                $extension = $req->file('song')->getClientOriginalExtension();

                $chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
			    $filename = $id.time().str_replace($chrc, '', $original_name);
                $audiopath = public_path('contents/songs/');
                $all_audios = $song->move($audiopath, $filename);

                if ($all_audios) 
                {
                    $payload = [
                        'song' => $filename,
                        'updated_by' => Auth()->user()->id,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
        
                    $data = Song::where(['song_id' => $req['song_id']])->update($payload);
        
                    if ($data)
                    {
                        $response = [
                            'message' => 'proceed success',
                            'status' => 'ok',
                            'code' => '201',
                            'data' => Song::where(['song_id' => $req['song_id']])->first()
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
            } else {
                $response = [
                    'message' => 'failed to upload song',
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
            'song_id' => 'required|string|min:0|max:17|unique:songs',
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
            'is_available' => 'required|boolean',
            'category_id' => 'required|integer'
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
                'song_id' => $req['song_id'],
                'name' => $req['name'],
                'description' => $req['description'],
                'status' => $req['status'],
                'is_available' => $req['is_available'],
                'category_id' => $req['category_id'],
                'created_by' => Auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $data = Song::insert($payload);

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Song::where(['song_id' => $req['song_id']])->first()
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
            'song_id' => 'required|string|min:0|max:17',
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
            'is_available' => 'required|boolean',
            'category_id' => 'required|integer'
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
                'description' => $req['description'],
                'status' => $req['status'],
                'is_available' => $req['is_available'],
                'category_id' => $req['category_id'],
                'updated_by' => Auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $data = Song::where(['song_id' => $req['song_id']])->update($payload);

            if ($data)
            {
                $response = [
                    'message' => 'proceed success',
                    'status' => 'ok',
                    'code' => '201',
                    'data' => Song::where(['song_id' => $req['song_id']])->first()
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
            'song_id' => 'required|string|min:0|max:17',
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
            $data = Song::where(['song_id' => $req['song_id']])->delete();

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
