<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
</head>
<body style="font-family: 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="background-color: #FFDF00; padding: 20px; text-align: center;">
                <h1 style="color: #333;">Īpašumu <a href="{{$url}}" style="color: #333; text-decoration: none;">{{$nosaukums}}</a> nepieciešams izdzēst</h1>
            </td>
        </tr>
        <tr>
         
            <td style=" padding: 20px;">
                <p style="font-size: 20px;"> Īpašuma dati</p>
                <p style="font-size: 18px;"> Pievienošanas datums: <span style="font-weight: bold;">{{ date('d-m-Y', strtotime($datums)) }} </span></p>
                <p style="font-size: 18px;"> Īpašuma nosaukums: <span style="font-weight: bold;"><a href="{{$url}}" style="color: #333; text-decoration: none;">{{$nosaukums}}</a></span></p>
                <p style="font-size: 18px;"> Atbildīgais aģents: <span style="font-weight: bold;">{{ $agent}}</span></p>
                <p style="font-size: 18px;"> Tagadējais īpašuma statuss: <span style="font-weight: bold;">{{ $iepr_loma}}</span></p>
                <p style="font-size: 18px;"> Vēlamais īpašuma statuss: <span style="font-weight: bold;">{{ $loma}}</span></p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #333; color: #fff; text-align: center; padding: 10px;">
                &copy; 2023 LVKV
            </td>
        </tr>
    </table>

</body>
</html>
