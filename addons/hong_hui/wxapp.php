<?php


class wxapp
{
    function doPageImage()
    {
        load()->func('logging');
        logging_run('doPageImage');
        return json_encode(['a'=>'c']);
    }
}
