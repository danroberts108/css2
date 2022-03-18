<?php

class RandomFloat
{
    //Function to create a random float
    public function rfloat($start, $end, $dplaces) {
        $scale = pow(10, $dplaces);
        return mt_rand($start * $scale, $end * $scale) / $scale;
    }
}