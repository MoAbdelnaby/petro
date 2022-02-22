<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>NCMS Notification</title>
    <style type="text/css" rel="stylesheet" media="all">
        /* Base ------------------------------ */
        *:not(br):not(tr):not(html) {
            /*font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;*/
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            width: 100% !important;
            height: 100%;
            margin: 0;
            /*line-height: 1.4;*/
            /*background-color: #F5F7F9;*/
            /*color: #839197;*/
            -webkit-text-size-adjust: none;
        }

        /*a {*/
        /*    color: #414EF9;*/
        /*}*/

        .ql-align-right{
            text-align: right;
        }

        .ql-align-center {
            text-align: center;
        }
        /*Media Queries ------------------------------ */
        @media only screen and (max-width: 600px) {
            .email-body_inner,
            .email-footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
        {!! $content !!}
</body>
</html>
