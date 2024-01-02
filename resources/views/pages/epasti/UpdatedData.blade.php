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
                <h1 style="color: #333;">{{$temats['temats']}} {{$temats['temats1']}}  {{$temats['temats2']}} <a href="{{ $data['url'] }}" style="color: #333; text-decoration: none;">{{ $data['nosaukums'] }}</a> {{$temats['temats3']}}</h1>
            </td>
        </tr>
        <tr>
        
       
           <td style="padding: 20px;">
    <p style="font-size: 20px;">{{$temats['nosaukums1']}}</p>
    <!-- Access data array -->
    <p style="font-size: 18px;">Pievienošanas datums: <span style="font-weight: bold;">{{ date('d-m-Y', strtotime($data['datums'])) }} </span></p>
    <p style="font-size: 18px;">Īpašuma nosaukums: <span style="font-weight: bold;"><a href="{{ $data['url'] }}" style="color: #333; text-decoration: none;">{{ $data['nosaukums'] }}</a></span></p>
     <p style="font-size: 18px;"> īpašuma statuss: <span style="font-weight: bold;">{{ $data['iepr_loma'] }}</span></p>
     @if ($data['iepr_loma'] == 'Rezervēts līdz')
     <p style="font-size: 18px;"> Rezervēts līdz : <span style="font-weight: bold;"> {{ date('d-m-Y', strtotime($data['rezervetslidz'])) }} </span></p>
    <p style="font-size: 18px;">Atbildīgais aģents: <span style="font-weight: bold;">{{ $data['agent'] }}</span></p>
   <p style="font-size: 18px;">Termiņš mājaslapai: <span style="font-weight: bold;">{{ date('d-m-Y', strtotime($data['termins'])) }}</span></p>
   @else
    <p style="font-size: 18px;">Atbildīgais aģents: <span style="font-weight: bold;">{{ $data['agent'] }}</span></p>
   <p style="font-size: 18px;">Termiņš mājaslapai: <span style="font-weight: bold;">{{ date('d-m-Y', strtotime($data['termins'])) }}</span></p>
   @endif
   
   
</td>
</tr>
<tr>
<td style="padding: 20px;">
    <p style="font-size: 20px;">{{$temats['nosaukums2']}}</p>
    <!-- Access newdata array -->
    <p style="font-size: 18px;">Pievienošanas datums: <span style="font-weight: bold;">{{ date('d-m-Y', strtotime($newdata['datums'])) }} </span></p>
    <p style="font-size: 18px;">Īpašuma nosaukums: <span style="font-weight: bold;"><a href="{{ $newdata['url'] }}" style="color: #333; text-decoration: none;">{{ $newdata['nosaukums'] }}</a></span></p>
   
    
    @if ($newdata['iepr_loma'] == 'Rezervēts līdz')
     <p style="font-size: 18px;"> Īpašuma statuss: <span style="font-weight: bold;">{{ $newdata['iepr_loma'] }}</span><span style="font-weight: bold;"> {{ date('d-m-Y', strtotime($newdata['rezervetslidz'])) }} </span></p>
    <p style="font-size: 18px;">Atbildīgais aģents: <span style="font-weight: bold;">{{ $newdata['agent'] }}</span></p>
   <p style="font-size: 18px;">Termiņš mājaslapai: <span style="font-weight: bold;">{{ date('d-m-Y', strtotime($newdata['termins'])) }}</span></p>
   @else
    <p style="font-size: 18px;"> Īpašuma statuss: <span style="font-weight: bold;">{{ $newdata['iepr_loma'] }}</span></p>
    <p style="font-size: 18px;">Atbildīgais aģents: <span style="font-weight: bold;">{{ $newdata['agent'] }}</span></p>
   <p style="font-size: 18px;">Termiņš mājaslapai: <span style="font-weight: bold;">{{ date('d-m-Y', strtotime($newdata['termins'])) }}</span></p>
   @endif
    
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
