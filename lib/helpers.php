<?php

function to_pounds($pence)
{
    return '£'.round($pence/100,2);
}
