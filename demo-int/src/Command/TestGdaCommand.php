<?php
namespace App\Command;
use Grdf\GdaApiBundle\Accreditation\Client\{
    GdaClientInterface,
    GdaSoapClient
};
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestGdaCommand extends Command
{
    protected static $defaultName = 'grdf:gda:test';
    private $gdaClient;

    public function __construct(GdaClientInterface $gdaClient)
    {
        parent::__construct();

        $this->gdaClient = $gdaClient;
        $token = "eyJ0eXAiOiJKV1QiLCJ6aXAiOiJOT05FIiwia2lkIjoiRXoreERNWWlOUmt4REVoZGgvSm9hMDJLYXdNPSIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiJncmRmX21lZ3JkZiIsImN0cyI6Ik9BVVRIMl9TVEFURUxFU1NfR1JBTlQiLCJhdWRpdFRyYWNraW5nSWQiOiI3YjdiMzVlMy0wMTQ3LTQ5N2EtOGU2Mi1kNmU0MjI0MWQ2MTItMTU3MjI0IiwiaXNzIjoiaHR0cHM6Ly9zb2ZpdC1zc28tb2lkYy1yZWNldHRlLmdyZGYuZnIvb3BlbmFtL29hdXRoMi9leHRlcm5lR3JkZiIsInRva2VuTmFtZSI6ImFjY2Vzc190b2tlbiIsInRva2VuX3R5cGUiOiJCZWFyZXIiLCJhdXRoR3JhbnRJZCI6IlhzZ3M2Z1pjWkYyWlJwaVJVbFRTOHpfel8tSSIsImF1ZCI6ImdyZGZfbWVncmRmIiwibmJmIjoxNjE3MzU4MjI5LCJncmFudF90eXBlIjoiY2xpZW50X2NyZWRlbnRpYWxzIiwic2NvcGUiOlsiL3YxL2FjY3JlZGl0YXRpb24iLCJCMkNfQjJFX0dEQSIsIm9wZW5pZCIsInByb2ZpbGUiLCIvdjEvYWNjcmVkaXRhdGlvbnMiLCJlbWFpbCJdLCJhdXRoX3RpbWUiOjE2MTczNTgyMjksInJlYWxtIjoiL2V4dGVybmVHcmRmIiwiZXhwIjoxNjE3NDQ0NjI5LCJpYXQiOjE2MTczNTgyMjksImV4cGlyZXNfaW4iOjg2NDAwLCJqdGkiOiJQR3JUSkp3ZWJDR1NXZldOWno0aE5BcUVWS0kiLCJ1X2VtIjoiR1JERi1TSURDIiwicnMiOiJHUkRGLVNJREMiLCJjbGllbnRfaWQiOiJncmRmX21lZ3JkZiJ9.IecBaDQiLmTRCpSA0uZOZPzFPDmbls5tIKuzFunn7jH-ZyTq7zpVsigyIHY1b9kyAEiuKGO1Jy-3ZjQXXg6mubDmkZH0Rxu7GhR_AVT9sdyTjMnT6U-gO9l0hvqhF4UI7yNd-7BBxZNituTJ31uKnnyCtawQVC6MEb0QLu5ZXXB6EIiKmoJSw2MoB1QkyDcD_pWnw9a2p5DuWp_E5fZO9Rrxf0hMdvavB87ng6r8UsE_ZsEn1y96aJh5Nfae1rTtk8duzRbK1Qg8-Iyx5Pc_z-qTjUYQHuQlYDG1k46gaFLxa5G0kEIChJR05QVzMSksa88qMrOEESsMvPgwnsodEg";
        $this->gdaClient->setToken($token);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $idInternaute = '7rpcjzen44d80h0gp4wj4khkbiq1q8tua5g8bhxgk26fjxxsi873sxi0xj9z9ckfiokt91o4m03';
        $idObject = '21163531086231';
        $alias = 'mario test03';

        $dd = $this->gdaClient->updateAccreditations($idInternaute, $idObject, $alias);
        dump($dd);

        $gdaResponse = $this->gdaClient->getUserAccreditation($idInternaute, $idObject);
        dd($gdaResponse);
    }
}