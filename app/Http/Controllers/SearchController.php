<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Google\GenerativeAi;

class SearchController extends Controller
{
    public function showSearchForm()
    {
        return view('location-search');
    }

    public function search1(Request $request)
    {
        $term = $request->input('term');
        
        if (empty($term)) {
            return response()->json([]);
        }

        // Step 1: Get city suggestions with browser-like headers
        $suggestionResponse = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/91.0.4472.124 Safari/537.36',
            'Cookie' => 'agoda.user.03=UserId=1c4a4475-5aa5-4398-8128-420fb4ada197; agoda.prius=PriusID=0&PointsMaxTraffic=Agoda; agoda.version.03=CookieId=e7ee010c-c7a4-4449-a436-6509a77f3027&DLang=en-us&CurLabel=NGN; agoda.price.01=PriceView=1; FPID=FPID2.2.Utgqcr%2FZB6QOj%2FFmOTWrRRyiD37vbsYJcsBFQPQa1Eo%3D.1765575231; _fbp=fb.1.1765575243605.82654989758290810; t_pp=oTXRDw2gug/ZuAJu:4O7mll7vzUU3quyBN/i1Qg==:xkWekZGnfprvlueYmjKJHxuM7G23+AHkw5cQCjCLiS4W8BAKm7yaYiqEF2cSUPXGvJl8ITdhzP3gxK71bpNAN1r2c6hl7Vzbwz1Buo79Q5mmgO0e+96u+HWRc4kxo/K9FbmMYlZvFVWl6RcG4PonBDrwu0TImvIXHdDvECQIVFqz/5KZJTtQqKG8pHawEkIIiNgOhxl45dG/A5JFzBh/NyoFx3cntahdt98uiquwZx7ORw==; ASP.NET_SessionId=vlp1f0fh0dvowrgvsdfmzpsc; agoda.mse.01=%7B%22property%22%3A%5B%5D%2C%22activity%22%3A%5B%5D%7D; agoda.lastclicks=1922878||9c6545bc-1666-4ddf-9cd0-c70620f2972d||2025-12-29T15:59:07||vlp1f0fh0dvowrgvsdfmzpsc||{"IsPaid":true,"gclid":"Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB","Type":""}; agoda.attr.03=ATItems=-1$12-13-2025 04:32$|1922878$12-29-2025 15:59$9c6545bc-1666-4ddf-9cd0-c70620f2972d; agoda.landings=1922878|9c6545bc-1666-4ddf-9cd0-c70620f2972d||vlp1f0fh0dvowrgvsdfmzpsc|2025-12-29T15:59:06|True|19----1922878|9c6545bc-1666-4ddf-9cd0-c70620f2972d|Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB|vlp1f0fh0dvowrgvsdfmzpsc|2025-12-29T15:59:07|True|20----1922878|9c6545bc-1666-4ddf-9cd0-c70620f2972d|Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB|vlp1f0fh0dvowrgvsdfmzpsc|2025-12-29T15:59:07|True|99; tealiumEnable=true; utag_main=v_id:019b147bb1c900b059ab1d9c96400506f00160670093c$_sn:2$_se:1$_ss:1$_st:1767000549718$ses_id:1766998749718%3Bexp-session$_pn:1%3Bexp-session; agoda.consent=NG||2025-12-29 08:59:10Z; _gcl_aw=GCL.1766998751.Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB; __gads=ID=bb9ec13195ef35a8:T=1766998751:RT=1766998751:S=ALNI_MYbseiLyXksyUv6u0_kRZh3v3j2_A; __gpi=UID=000012bca2072489:T=1766998751:RT=1766998751:S=ALNI_MaM9blYv_8JdNibmrrCQ3ml1m1Qzw; _uetsid=a4ab88e0e49411f0bc921d2601d3fb99|1ibp5ln|2|g29|0|2189; _uetvid=42e300a0d7a211f0927499588b10ffeb|1jnq99i|1766998753874|2|1|bat.bing.com/p/conversions/c/z; _gid=GA1.2.194559772.1766998754; _gac_UA-6446424-30=1.1766998754.Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB; _gcl_au=1.2.816925682.1765575227; _ga_C07L4VP9DZ=GS2.2.s1766998754$o2$g0$t1766998754$j60$l0$h0; _ga_T408Z268D2=GS2.1.s1766998751$o2$g1$t1766998755$j56$l0$h1200454160; agoda_ptnr_tracking=137949ec-3943-42b4-858c-2787abf1bed8; __RequestVerificationToken=ZcFIxhEqo7mBYz578JT1J1yvH_x23mB9NaLmJ6Kem9ztFgx_1wuB1bVE4tGHZnsJU77KHuJpWChjk7vYL8KGAwCx5YE1; cto_bundle=WR9T8l9SUnJGeHV5dmJYSnVwVG5udkQySDFWRllBblVUeWh5MVBQMmJXeDFpRHNacFlhODliQlJ3dWtNRm4lMkJadUhDVTc4bzRERXJrZWNUMUFJbVZaMiUyRjdzQ2JrMkthakdXdHpyZjBLMW9Ta3owYXBKV3dwN2hmS1k2MlN1VlJGeFhVVmIlMkJCM2Yzd3JEQVRMMnRSSGxEOFRUY3clM0QlM0Q; _ga_PJFPLJP2TM=GS2.1.s1766998778$o1$g0$t1766998778$j60$l0$h0; ai_user=UoEopTUTZVb6PMUq70Y79E|2025-12-29T08:59:38.232Z; ai_session=W2rYXkspG8qZroVYbz6llq|1766998778746|1766998778746; ul.session=ccf4bab7-f5b5-4478-bba8-b17113ac8cfe; xsrf_token=CfDJ8Dkuqwv-0VhLoFfD8dw7lYx22PONZpW430INVBPUVcix4bgm6jFZ79nBJqweylkPifiZcar2G7c9PQXD5jGwhgsmzXROYTQa24BkZmuQ2azuPWyk9ErHQeO-mOykenRWJ7H8vBmnjGcQQtH2nzU-bjk; ul.pc.token=eyJhbGciOiJFUzI1NiJ9.eyJtIjo0MjYzMDk5MjMsInIiOlsiMTI3XzM0ODM4NSJdLCJlIjoiPTd0JEAjVTluc0pASl9bW3RnPSskY3QjLD1MRVV1ckR1IzxRaXU8dCQ6VyFiNFldSDpAUlJQPF9FWiorKmthVUNfLmEmK0BacGBOSzFAPkQiLCJzcmMiOiJzcmMiLCJzdWIiOiJRaHJZakduZFJpR2lOVnFlbWFOVEl3IiwianRpIjoiZ1VGR0ZGOXlReHFKdXJKdEk2ZmNLZyIsImlhdCI6MTc2Njk5ODc4MywiZXhwIjoxNzc0Nzc0NzgzLCJ3bHQiOiJmMWE1OTA1Zi05NjIwLTQ1ZTUtOWQ5MS1kMjUxYzA3ZTBiNDIiLCJzIjoyfQ.OFYdiSc-NgJ8lEdAFumpvLXH3amvRosfUWdpzUHJ1gf_2NV5PKleg90eGuWebn742PEZjPPOlGpNy9uvBiSUuw; _ga=GA1.1.137797662.1765575231; _ga_80F3X70H1C=GS2.1.s1766998857$o1$g0$t1766998857$j60$l0$h0; agoda.analytics=Id=9196862786460344372&Signature=-3848233439802041329&Expiry=1798538622000; t_rc=t=43&8ETD+1m6XA3NQYm7DVQvpQ=1',
            'Accept' => 'application/json',
        ])->get('https://partners.agoda.com/HotelSuggest/GetSuggestions', [
            'type' => 1,
            'limit' => 10,
            'term' => $term,
        ]);

        return response()->json($suggestionResponse->json());
    }  







    public function search(Request $request)
    {
        $term = $request->input('term');

        if (empty($term)) {
            return response()->json([]);
        }

        // Temporary test data to verify frontend works
        if ($term === 'test') {
            return response()->json([
                ['DisplayText' => 'Test Location 1'],
                ['DisplayText' => 'Test Location 2'],
                ['DisplayText' => 'Test Location 3']
            ]);
        }
 
        try {
            $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/91.0.4472.124 Safari/537.36',
            'Cookie' => 'agoda.user.03=UserId=1c4a4475-5aa5-4398-8128-420fb4ada197; agoda.prius=PriusID=0&PointsMaxTraffic=Agoda; agoda.price.01=PriceView=1; FPID=FPID2.2.Utgqcr%2FZB6QOj%2FFmOTWrRRyiD37vbsYJcsBFQPQa1Eo%3D.1765575231; _fbp=fb.1.1765575243605.82654989758290810; agoda.lastclicks=1922878||9c6545bc-1666-4ddf-9cd0-c70620f2972d||2025-12-29T15:59:07||vlp1f0fh0dvowrgvsdfmzpsc||{"IsPaid":true,"gclid":"Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB","Type":""}; _ga_80F3X70H1C=GS2.1.s1766998857$o1$g0$t1766998857$j60$l0$h0; _gcl_aw=GCL.1770651786.Cj0KCQiArt_JBhCTARIsADQZaymoAn8XEBrTKj01tC5TPi-TqhEmLD8Rir7MkP4d-gZDO8vN6nwEaGgaArIQEALw_wcB; _gac_UA-6446424-30=1.1770651788.Cj0KCQiArt_JBhCTARIsADQZaymoAn8XEBrTKj01tC5TPi-TqhEmLD8Rir7MkP4d-gZDO8vN6nwEaGgaArIQEALw_wcB; deviceId=dc954ba7-7246-4dcd-8f72-eccde0e18dfe; agoda.familyMode=Mode=0; _ga_PWCRSK2Y5Y=GS2.1.s1770920236$o1$g0$t1770920237$j59$l0$h694724981; agoda_ptnr_tracking=dd591730-e8ef-4221-ab59-22f2ad312886; ai_user=sVplkHAWTi8KeanjOQy4mg|2026-03-06T06:17:45.270Z; partnerLocale=en-us; agoda.search.01=SHist=4$13827042$9246$5$1$2$1$0$1770713392$17|4$4519329$9246$5$1$2$1$0$1772778025$17|4$18885169$9341$5$1$2$1$0$1774291594$17|1$571$9221$1$1$2$0$0$1774380287$|4$69684815$9221$1$1$2$0$0$$&H=9214|43$13827042|19$4519329|1$18885169|0$69684815$15683738; agoda.version.03=CookieId=e7ee010c-c7a4-4449-a436-6509a77f3027&DLang=en-us&CurLabel=USD; tealiumEnable=true; utag_main=v_id:019b147bb1c900b059ab1d9c96400506f00160670093c$_sn:10$_se:1$_ss:1$_st:1774735329758$ses_id:1774733529758%3Bexp-session$_pn:1%3Bexp-session; agoda.consent=NG||2026-03-28 21:32:10Z; _ga_T408Z268D2=GS2.1.s1774733530$o15$g1$t1774733530$j60$l0$h390637764; FPLC=0U7A6ZB%2Fz%2FXofXqryh9Mvf77AEgYMkACOLdTg8hNosoIqNYFS6%2Bd6g5mFAMwwrST97j9vDAQht2TbeEQArQMYGFdIhhNQNh7yHbUqvko41ckutovWZuMnrH6F4vxeg%3D%3D; __gads=ID=bb9ec13195ef35a8:T=1766998751:RT=1774733533:S=ALNI_MYbseiLyXksyUv6u0_kRZh3v3j2_A; __gpi=UID=000012bca2072489:T=1766998751:RT=1774733533:S=ALNI_MaM9blYv_8JdNibmrrCQ3ml1m1Qzw; _uetsid=943def502aed11f1aa3caffe3e83126b|18eu4s3|2|g4q|0|2278; _uetvid=42e300a0d7a211f0927499588b10ffeb|pybbdr|1774733531473|1|1|bat.bing.com/p/conversions/c/f; _gid=GA1.2.184887786.1774733534; _gcl_au=1.2.1333527261.1774275576; _ga_C07L4VP9DZ=GS2.2.s1774733534$o10$g0$t1774733534$j60$l0$h0; cto_bundle=pT9YKl9SUnJGeHV5dmJYSnVwVG5udkQySDFlU1pEeDJDMnhIQTB4WHFDa0d6c2NPUmtxZnl6cnEzanJsNDZ3QkVSUFd3aFN0ZnIxY3dlQkpDUmFqbkVETHhzU1AlMkY4RGV2dmxNJTJCS2ZPSENoY1c1a0E1dTJ5QUJrUTRva0lyTmtmV0YyMG45Qm5WeWFYciUyQkVhUVloNHpXSCUyRmdIUSUzRCUzRA; __RequestVerificationToken=FwLbHqdKInQt3POqb8TyLOp2XltVNHgG8X5wE9DvkVCXEFzfo2diGxoMYGg2w0kC_ctMVThwL1LEbdX7pR_qwgUm2uw1; t_pp=R17hSqYh2q5HyWup:RoYL9xANwePn4wXwkRhOrg==:UWOH70K2mbaqibSDHT+UC8ugCvK7UfvaFOXJhy5xD7hlIpn29gvRN9QTXCEeIlop8beHL1+oyrFZ0XS98CZ794c8UfO126s+tvIMOupeCiJbr1kDCHAYwf+vC2Y1vg0lVOWnXhm7vxLgxouBV2HAN/e6juyAKQXzBgt4FldlZ2BiZTuDkahgEr1pEqzSX1SQrHSEnQAQD4vjau9+b133yRY/TPHucEH1N0Te5VsXQBk63P0o9PAv; ai_session=cndk+9A1je22+gE2F6f5Dv|1774772919981|1774772919981; ul.session=092aeb3a-606f-4eab-84cc-d875bf396211; agoda.landings=1739459|||mwwcesgp2uwnkmbbgbkbvgd2|2026-03-29T15:28:40|True|19----1739459|||mwwcesgp2uwnkmbbgbkbvgd2|2026-03-29T15:28:40|True|20----1739459|||mwwcesgp2uwnkmbbgbkbvgd2|2026-03-29T15:28:40|True|99; agoda.attr.03=ATItems=-1$12-13-2025 04:32$|1922878$02-09-2026 22:42$9c6545bc-1666-4ddf-9cd0-c70620f2972d|1942345$02-10-2026 15:49$|-1$03-06-2026 13:16$|1739459$03-06-2026 13:17$|-1$03-23-2026 21:19$|1739459$03-23-2026 21:19$|1942345$03-25-2026 02:23$|1844104$03-25-2026 02:25$|-1$03-29-2026 04:32$|1739459$03-29-2026 15:28$; ASP.NET_SessionId=mwwcesgp2uwnkmbbgbkbvgd2; agoda.attr.fe=1739459|||mwwcesgp2uwnkmbbgbkbvgd2|2026-03-29T15:28:40|True|2026-03-30T15:28:40|xiJS23prEMxG3eQz; xsrf_token=CfDJ8Dkuqwv-0VhLoFfD8dw7lYyLcGzXLJbSYisbroekWQHIuGgudQVNFesraIJN-ADdnYXgkEfr6kE1iuYU0yDR4hiCne9fvZlh0qqggVSeXSG8ywYIdAArG46eO1Fxu5BrXIqmkLGot7TswAcn1aVKoGU; ul.pc.token=eyJhbGciOiJFUzI1NiJ9.eyJtIjo0MjYzMDk5MjMsInIiOlsiMTI3XzM0ODM4NSJdLCJlIjoiTWBWVmM0TkBJXFxkTixMbyhNPVhqMDUzI0pxQmI0PzV0cSRWZGEuJlE4LEc1O1h1bWo4bWw4YTs8PGpaRzw7XkZpWlhWaXBLNDVbJ1JXM0dRIiwic3JjIjoic3JjIiwic3ViIjoiUWhyWWpHbmRSaUdpTlZxZW1hTlRJdyIsImp0aSI6IkRWNHNhOHRRUnBpdHBjMTFHMUZBZ0EiLCJpYXQiOjE3NzQ3NzI5MjgsImV4cCI6MTc4MjU0ODkyOCwid2x0IjoiZjFhNTkwNWYtOTYyMC00NWU1LTlkOTEtZDI1MWMwN2UwYjQyIiwicyI6MiwibGF0IjoicGFydG5lcmNlbnRlciJ9.YR-uBBYu6TdffbMxP1YxM7zwEXCobPx5TScRvOfACYfg2CHH2mK2ZLrIEPJmgX1dPsHf0uLe2H49q_hupwwwRw; _ga=GA1.2.137797662.1765575231; _ga_PJFPLJP2TM=GS2.1.s1774772918$o7$g1$t1774772953$j25$l0$h0; agoda.analytics=Id=-7972103523696677307&Signature=2006607592920049195&Expiry=1774776566206; t_rc=dD00MSY4RVREKzFtNlhBM05RWW03RFZRdnBRPTEmdWlkPTFjNGE0NDc1LTVhYTUtNDM5OC04MTI4LTQyMGZiNGFkYTE5Nw==.xE8ypVMZdeA6ScWORaoZxsFSqkWGYNWow5MBWEBwrMk=',
            'Accept' => 'application/json',
        ])->timeout(10) // Prevent long hangs
          ->retry(2, 200) // Retry on transient errors
          ->withOptions([
              'verify' => false, // use with caution, only for dev
              'curl' => [
                  CURLOPT_FOLLOWLOCATION => true,
              ],
          ])
          ->get('https://partners.agoda.com/HotelSuggest/GetSuggestions', [
              'type' => 1,
              'limit' => 10,
              'term' => $term,
          ]);

        if ($response->successful()) {
            $data = $response->json();
            Log::info('Agoda API Response:', $data);
            return response()->json($data);
        } else {
            Log::error('Agoda API Error:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Unable to contact Agoda API',
            'message' => $e->getMessage()
        ], 500);
    }
}
}
