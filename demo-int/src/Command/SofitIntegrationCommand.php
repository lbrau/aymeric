<?php

namespace App\Command;
use App\Model\Person;
use App\Normalizer\SofitNormalizer;
use Grdf\SofitBundle\Model\SofitResourceInterface;
use Grdf\SofitBundle\Model\SofitUserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Grdf\SofitBundle\Client\SofitClient;
use Grdf\SofitBundle\Model\SofitUser;

class SofitIntegrationCommand extends Command
{
    private const MAX_CHARACTERS_EMBED = 75;
    private const CHARACTERS_CHOICE_PANEL = '0123456789abcdefghijklmnopqrstuvwxyz';
    private const RAMDOM_STRING_PREFIX = '';

    protected static $defaultName = 'grdf:sofit:integration';
    protected static $defaultDescription = "grdf:sofit:integration";
    private $sofitClient;
    private $sofitLogger;
    private $serializer;

    public function __construct(SerializerInterface $serializer, SofitClient $sofitClient,string $name = null, LoggerInterface $sofitLogger)
    {
        parent::__construct($name);
        $this->serializer = $serializer;
        $this->sofitClient = $sofitClient;
        $this->sofitLogger = $sofitLogger;
    }

    protected function configure()
    {
        // todo make integration command config implementation
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $groups = json_decode('{
            "groups": [
                "espaceperso",
                "paddixcrac",
                "opendatasoft",
                "monreseaugaz",
                "adminespaceperso"
            ]
        }
        ', true);

        $oldPassword = 'Hamdiafrit456';
        $newPassword = 'Hamdiafrit434';
        $idInternaute = 'id';

        $newToken = $this->sofitClient->generateToken();
        ['tokenId' => $tokenId, 'successUrl' => $successUrl, 'realm' => $realm] = json_decode($newToken, true);
        $this->sofitClient->setToken($tokenId);
//        $this->sofitLogger->critical("hello Critical");
        /** @var SofitUser $user */
        $user = $this->getExternalUser('y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj');
        $user->setMail('broly.brau2ee@mail.com');
        $user->setSn('Hamdoussiii');

        $lostPasswordToken = "eyJ0eXAiOiJKV1QiLCJjdHkiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.ZXlKMGVYQWlPaUpLVjFRaUxDSmxibU1pT2lKQk1USTRRMEpETFVoVE1qVTJJaXdpWVd4bklqb2lVbE5CTVY4MUluMC5oalBJeXd4cXZaRWdqcXlqeS1UdmtBeEUyaUhiQzRabGdpc01iS3Fvc3pDejVtd0FyeXVLRGdfRXR6cExXTkxLc1JZMnNJcEY5ZVVmV0M1SnNLdTlVNTFFM3g1UHRGRDBYd3BtenE2Vkl3blpIdWJJUnR3TWg3V0Q1VlVlVGVOb01IbEtEUzk5ZklfRlc2ZVNtUVF3NWJ3LUw3elBCYVNTdW4tTy1hWW5nNWF6ck1VQ3g0dE9IelJQSHZZdUNydkR5b3hRQjVyZFF2QmVqOVhGeUFZUDBoZHJySkpjY3p5dDhCeWxYNW0yTnJabWo2NTBfNjBsWHRnSXotUjZxUnhOY3BWUzN3bHljOTQ2Sy1GZUttaXZNdzdRWjZ4UjBMQ05aejNnRHY5NlA0akI0NlBSZzF3Uy05eHBxbEhVbTVPZXpTZFN2aDRGb1IzUE9aN0ZVTGlmaHcuWGsyUUE2aHU0Y1dwQUNUbld5allFUS4tNTVhbGU2NjFIazY2WmlRS09pSm13am8wWGFKc1d1YXhkcktNSmNJU0g3YklwQTJiMVlwbmlqR0VYaVY4M1NfTlFaalg3bFdWTjV2QzlJRWZGRHZuVWhzLXNMNkZHOUZPbTlBd3l0a3I1YzBpd1J3blRiSVdBMGlPQl92SnptN3d3eGtWeUtvYWg5TGhwZ1ZKWjVpci1kWEQyNUxkVFpPODNIRzVHM1k1Nm90bW5vOGxKZkJSMjV6cnhKaURkaG5jSFZRb1ZfakJqQW1UT2FJTjhpSHlGbmxpY2xvN0U3TDBKS2txc1ZOZVFaOEV2SUJnTHlWZ3IxOEN0clp3MEJ0ZFk5TDlZcXN2Tjc1X3lDcHVEWTNDYmE3U09sN1IxLTRwX0pHdlpJa3JCNFI4ZjN5QzFZOUdiU21TVGY2VW52OU5JazEwR0VqeTVBUjhPb2JJc3BFSlVWZ3N4VjB0Y0pZZjhydldmUmhRMVVyMzZfT1hZWndfRFpJSUN0ZGJycnVZaWcwZEVKclVISVBoWlNkcUM2QTdSS2RuNWI5WFlpSkpBZTNURTBGV0NMRTlFMVhGR3J4WnJfaHV6NEZJaUxpU1F1bFVXMEVFcktJYjB0cVl2dWJBQS5oU0ZGbjRXa3VHVF9ma1BnWHlPSDR3.ZFQOLQYFdMkSvjIX-684YYUXtqDUjGjnpSjXeM_TkdA";
        $newPassword = 'Pacman12345';

//        dump($this->getInternalUser('y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj')); // NotOk
//        dump($this->searchUserHabilitation('y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj')); // ok
//        dump($this->searchUserByEmail('HAMDI.AFRIT@1985.com')); // ok
        $this->createUserAccountCommand(); // ok
//        dump($this->activateUserAccountCommand('7k8bh8n8jkk050in51eztt9jlpgmxxmqnbnlq41h936ejt9w2ky3proijnphz5niy8lbvai2wbz', $tokenId)); // ok
//        dump($user, $this->updateUserAccountCommand($user, $tokenId)); // ok
//        dump($this->lostPassword('broly.brau2ee@mail.com')); // ok  : todo erreur 400 a gerer
//        dump('response : ', $this->updateUserHabilitation($groups, "01s3wixg163ob34hweonr9kkpyp15pfejjvu2owh0dge0rtd1vhjsxy8folkvvqwpxr0tx90bzy" )); // ok todo manage 401, 400 erreur. and response actually the sofitUser is not adapted
//        dump(
//            $this->updatePassword('###loloPacman$$$', 'PAPaacmann987654', 'y8j823d639zzd8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8i899upj')
//        ); // ok.
//        dump('reset response: ', $this->resetPassword('broly.brau2ee@mail.com', $newPassword)); //  ok

        return Command::SUCCESS;
    }

    // Test d'intégration getExternalUser ok !
    private function getExternalUser(string $id)
    {
        $newToken = $this->sofitClient->generateToken();
        ['tokenId' => $tokenId, 'successUrl' => $successUrl, 'realm' => $realm] = json_decode($newToken, true);
        $this->sofitClient->setToken($tokenId);

        return $this->sofitClient->getExternalUser($id);
    }

    // todo 404 mais pas possible de faire le test en 200 meme avec postman
    private function getInternalUser(string $id)
    {
        $newToken = $this->sofitClient->generateToken();
        ['tokenId' => $tokenId, 'successUrl' => $successUrl, 'realm' => $realm] = json_decode($newToken, true);
        $this->sofitClient->setToken($tokenId);

        return $this->sofitClient->getInternalUser($id);
    }

    private function searchUserHabilitation(string $id)
    {
        $newToken = $this->sofitClient->generateToken();
        ['tokenId' => $tokenId, 'successUrl' => $successUrl, 'realm' => $realm] = json_decode($newToken, true);
        $this->sofitClient->setToken($tokenId);

        return $this->sofitClient->searchUserHabilitation($id);
    }

    private function searchUserByEmail(string $email)
    {
        $newToken = $this->sofitClient->generateToken();
        ['tokenId' => $tokenId, 'successUrl' => $successUrl, 'realm' => $realm] = json_decode($newToken, true);
        $this->sofitClient->setToken($tokenId);

        return $this->sofitClient->searchUserByEmail($email);
    }

    private function createUserAccountCommand(): void
    {
        $sofitUser = new SofitUser();
        $sofitUser->setUserName($this->generateUUID());
        $sofitUser->setGivenName('James');
        $sofitUser->setSn('Bond');

        $sofitUser->setMail('hellototo@mail.com');
        $sofitUser->setUserPassword('###pacmanpEass4564$$$');
        $sofitUser->setInetUserStatus('Inactive'); // 400 si pas dans une enum [Active|Inactive]
        dump('####',$this->sofitClient->createUserAccount($sofitUser));
    }

    private function activateUserAccountCommand($idInternaute, string $token): SofitUserInterface
    {
        return $this->sofitClient->activateUserAccount($idInternaute, $token);
    }

    public function updateUserAccountCommand(SofitUser $sofitUser, string $token): SofitUserInterface
    {
        return $this->sofitClient->updateUserAccount($sofitUser, $token);
    }

    public function lostPassword(string $email): array
    {
        return $this->sofitClient->lostPassword($email);
    }

    public function updateUserHabilitation(array $groups, string $idInternaute): array
    {
        return $this->sofitClient->updateUserHabilitation($groups, $idInternaute);
    }

    public function resetPassword(string $newPassword, string $lostPwdToken): array
    {
        return $this->sofitClient->resetPassword($newPassword, $lostPwdToken);
    }

    public function updatePassword(string $oldPassword, string $newPassword, string $idInternaute): SofitUserInterface
    {
        return $this->sofitClient->updatePassword($oldPassword, $newPassword, $idInternaute);
    }

    private function generateUUID(): string
    {
        $characters = self::CHARACTERS_CHOICE_PANEL;
        $randomString = self::RAMDOM_STRING_PREFIX;
        for ($i = 0; $i < self::MAX_CHARACTERS_EMBED; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }
}
