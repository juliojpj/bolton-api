<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use GuzzleHttp\Client;
use App\Http\Resources\NotaFiscal;
use App\Http\Resources\NotaFiscalCollection;
use App\Nota;

use Storage;

class NotaFiscalController extends BaseController
{
    public function index() {
        $continue = true;

        $uri = 'https://sandbox-api.arquivei.com.br/v1/nfe/received';
        $totalImported = 0;
        while ($continue) {
            $res = $this->getNotasArquivei($uri);
            $data = json_decode($res->getBody()->getContents(), true);

            $notasFiscais = array();
            foreach ($data['data'] as $nota) {
                $n = array(
                    'access_key' => $nota['access_key'],
                    'value' => $this->findTotalValue($nota['xml']),
                    'created_at' => date('Y-m-d H:m:s')
                );
                array_push($notasFiscais, $n);
            }

            $insert = Nota::insert($notasFiscais);
            
            $totalImported += $data['count'];
            if ($data['count'] < 50)
                $continue = false;
            else
                $uri = $data['page']['next'];
        }

        return $this->sendResponse($insert, $totalImported.' notas importadas!');

    }

    private function getNotasArquivei($uri) {
        $client = new Client();
        $res = $client->request('GET', $uri, [
            'headers' => [
                'Content-Type'     => 'application/json',
                'x-api-id' => 'f96ae22f7c5d74fa4d78e764563d52811570588e',
                'x-api-key'      => 'cc79ee9464257c9e1901703e04ac9f86b0f387c2'
            ]
        ]);

        return $res;
    }

    private function findTotalValue($nota) {
        $xml = simplexml_load_string(base64_decode($nota));
        $xmlArray = $this->simpleXmlToArray($xml);

        if (isset($xmlArray['NFe']))
            $numero = $xmlArray['NFe'][0]['infNFe'][0]['total'][0]['ICMSTot'][0]['vNF'];
        elseif (isset($xmlArray['infNFe']))
            $numero = $xmlArray['infNFe'][0]['total'][0]['ICMSTot'][0]['vNF'];
            
            return $numero;
    }

    private function simpleXmlToArray($xmlObject, $out = array ())
    {
        foreach ($xmlObject as $index => $node ){
            if(count($node) === 0){
                $out[$node->getName()] = $node->__toString ();
            }else{
                $out[$node->getName()][] = $this->simpleXmlToArray($node);
            }
        }

        return $out;
    }
}
