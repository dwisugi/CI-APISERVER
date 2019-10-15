<?php 

class Render 
{
    public function result($data, $status = 200)
    {
        $data1 = [
            'status' => $status,
            'data' => $data,
        ];

        return $data1;
    }
}
    