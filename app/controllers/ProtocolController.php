<?php

class ProtocolController extends BaseController {

    public function getSupplements() {
        Auth::user()
            ->requires('read')
            ->ofScope('Subscriber',Subscriber::current()->id)
            ->orScope('Protocol')
            ->over('Supplement');

        $letter = Input::get('letter') ? rawurldecode(Input::get('letter')) : 'A';

        $supplements = Subscriber::current()
            ->supplements();

        $supplements =
            $letter == '#'
                ? $supplements->whereRaw("name REGEXP '^[^A-Za-z]'")
                : $supplements->where('name','LIKE',"$letter%");

        $supplements = $supplements
            ->orderBy('name','asc')
            ->get();

        return View::make('protocols.subviews.supplements')->with('supplements',$supplements);
    }

    public function getEdit($protocol) {
        Auth::user()
            ->requires('edit')
            ->ofScope('Subscriber',Subscriber::current()->id)
            ->orScope('Protocol')
            ->over('Protocol',$protocol->id);

        $schedules = $protocol->schedules;

        $schedulesOrdered = array();
        foreach($schedules as $schedule) {
            $index = $schedule->scheduletime->index;
            $schedulesOrdered[$index] = $schedule->toArray();
        }

        $schedules = array();
        arrayFlatten($schedulesOrdered,$schedules,'=>','schedules');
        $schedules['supplement'] = $protocol->supplement->id;

        return View::make('protocols.edit',array(
            'client'=>$protocol->client,
            'protocol'=>$protocol,
            'schedules'=>$schedules
        ));
    }

    public function postEdit($protocol) {
        Auth::user()
            ->requires('edit')
            ->ofScope('Subscriber',Subscriber::current()->id)
            ->orScope('Protocol')
            ->over('Protocol',$protocol->id);

        $input = array();
        arrayExpand(Input::all(),$input);

        $protocol->supplement_id = $input['supplement'];
        $protocol->save();

        foreach($protocol->schedules as $schedule) {
            $schedule->delete();
        }

        foreach($input['schedules'] as $scheduleData) {
            if(!isset($scheduleData['scheduletime_id'])) {
                continue;
            }

            if($schedule = Schedule::where('protocol_id',$protocol->id)
                ->where('scheduletime_id',$scheduleData['scheduletime_id'])
                ->first()
            ) {
                $schedule->update($scheduleData);
            }
            else {
                $scheduleData['protocol_id'] = $protocol->id;
                Schedule::create($scheduleData);
            }
        }

        return Redirect::to(URL::route('client',array($protocol->client->id)).'/#protocols');
    }

    public function postDelete($protocol) {
        Auth::user()
            ->requires('delete')
            ->ofScope('Subscriber',Subscriber::current()->id)
            ->orScope('Protocol')
            ->over('Protocol',$protocol->id);

        $protocol->delete();
        return Redirect::route('client',array($protocol->client->id));
    }

}