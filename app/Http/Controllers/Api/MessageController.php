<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /*protected $data;

    public function __construct()
    {
        // $this->data =  Message::with('sender')->with('recipient');
        $this->data =  Message::leftJoin('users as sender_user', 'sender_user.id', '=', 'messages.sender_id')
        ->leftJoin('users as rec_user', 'rec_user.id', '=', 'messages.rec_id')
        ->select('sender_user.nom as sender_nom', 'rec_user.nom as rec_nom','content');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Message::all();
    }

    public function conversations($sender_id, $rec_id)
    {   /*return Message::query()
        ->where('sender_id',  Auth::id())
        ->where('receiver_id',  $receiver_id)
        ->orWhere('receiver_id',  Auth::id())
        ->where('sender_id', $receiver_id)
        ->with('sender')
        ->with('receiver')
        ->get();*/

        return Message::query()
        ->where('sender_id',  $sender_id)
        ->where('rec_id',  $rec_id)
        ->orWhere('sender_id',  $rec_id)
        ->where('rec_id',  $sender_id)
        ->with('receiver')
        ->get();
    }

    public function seen($sender_id, $rec_id)
    {
        $message = Message::where('rec_id',$rec_id)->where('sender_id',  $sender_id);
        $message->update(['status' => true]);
        $response = [
            'message' => $message
        ];
        
        return response($response, 201);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'sender_id' => 'required | int | exists:users,id',
            'rec_id' => 'required | int | exists:users,id',
            'content' => 'nullable | string',
        ], $this->messages());

        if(isset($request->status)) $fields['status'] = true;

        $message = Message::create($fields);
        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return $message;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
        $response = ['message' => 'Message supprimée de la base de données'];
        return response($response,201);

    }

    private function messages()
    {
        return 
        [   
            'sender_id.required'    => 'Veuillez entrer l\'expéditeur du message',
            'rec_id.required'      => 'Veuillez entrer le destinataire du message',
            'sender_id.exists'      => 'Id de l\'expéditeur n\'existe pas dans la base',
            'rec_id.exists'      => 'Id de destinataire n\'existe pas dans la base',
        ];
    }
}
