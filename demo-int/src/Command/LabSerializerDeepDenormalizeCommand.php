<?php

namespace App\Command;

use App\Model\DeepModel;
use App\Model\DeepUserModel;
use App\Model\Person;
use App\Normalizer\DeepNormalizer;
use App\Normalizer\LabDeepNormalizer;
use App\Normalizer\SofitNormalizer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Grdf\SofitBundle\Client\SofitClient;
use Grdf\SofitBundle\Model\SofitUser;
use Doctrine\Common\Collections\ArrayCollection;

class LabSerializerDeepDenormalizeCommand extends Command
{
    protected static $defaultName = 'lab:serializer:deep_denormalize';
    protected static $defaultDescription = 'Add a short description for your command';
    private $serializer;
    private $sofitClient;
    /**
     * @var LoggerInterface
     */
    private $sofitLogger;
    /**
     * @var LoggerInterface
     */
    private $gdaLogger;


    public function __construct(SerializerInterface $serializer, SofitClient $sofitClient,string $name = null, LoggerInterface $sofitLogger)
    {
        parent::__construct($name);
        $this->serializer = $serializer;
        $this->sofitClient = $sofitClient;
        $this->sofitLogger = $sofitLogger;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->testDeepStream();
//        $this->testSerializeAlex();
//        $this->sofitLogger->critical("hello Critical");
//        //$this->createUserAccountCommand(); // problème avec le proxy: Couldn't resolve proxy name for "https://sofit-sso-oidc-recette.grdf.fr/openam/json/selfservice/userRegistration?_action=submitRequirements"
//        $this->activateUserAccountCommand();
//        $this->testNormalizer();


        return Command::SUCCESS;
    }

    /**
     * @return bool
     */
    protected function isB(): bool
    {
        return 1 === 2;
    }

    private function createUserAccountCommand()
    {
        // on test l'instance user
        // on test la validation
        // On teste la creation avec l'implementation legacy
        // on teste la désérialisation
        // On teste la creation avec la nouvelle implementation.

        $sofitUser = new SofitUser();
        $sofitUser->setUserName('y8j823659zzd8qt5695ns577ki328j4fknsi25y9442vf54xn4b25mixaqzy6z52usd8is6899u'); // 409 si memeusername
        $sofitUser->setGivenName('LaurentfromCmd');
        $sofitUser->setSn('BRAUFromCmd');
        $sofitUser->setMail('lolirock@iron.com');
        $sofitUser->setUserPassword('###pacmanpEass4564$$$');
        $sofitUser->setInetUserStatus('Inactive'); // 400 si pas dans une enum [Active|Inactive]

        $this->sofitClient->createUserAccount($sofitUser);
    }

    private function activateUserAccountCommand()
    {
        // on test l'instance user
        // on test la validation
        // On teste la creation avec l'implementation legacy
        // on teste la désérialisation
        // On teste la creation avec la nouvelle implementation.
        $sofitUser = new SofitUser();
        $sofitUser->setUserName('y8j823659zzd8qt5695ns577ki328j4fknsi25y9442vf54xn4b25mixaqzy6z52usd8is6899u'); // 409 si memeusername
        $sofitUser->setGivenName('LaurentfromCmd');
        $sofitUser->setSn('BRAUFromCmd');
        $sofitUser->setMail('lolirock@iron.com');
        $sofitUser->setUserPassword('###pacmanpEass4564$$$');
        $sofitUser->setInetUserStatus('Inactive'); // 400 si pas dans une enum [Active|Inactive]

        $this->sofitClient->createUserAccount($sofitUser);
    }

    private function cloneExecuteFunction()
    {
//                $jsonData = json_encode(['name' => 'CTO']);
        $jsonData = '{"_id":"y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj","_rev":"-1628117453","username":"y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj","realm":"/externeGrdf","uid":["y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj"],"mail":["hamdi.afrit@1985.com"],"universalid":["id=y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj,ou=user,o=externeGrdf,ou=services,dc=openam,dc=forgerock,dc=org"],"givenName":["Hamdi"],"objectClass":["iplanet-am-managed-person","inetuser","sunFederationManagerDataStore","sunFMSAML2NameIdentifier","sunIdentityServerLibertyPPService","inetorgperson","iPlanetPreferences","personnsofit","iplanet-am-user-service","forgerock-am-dashboard-service","organizationalperson","top","sunAMAuthAccountLockout","person","iplanet-am-auth-configuration-service"],"inetUserStatus":["Active"],"dn":["uid=y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj,ou=externeGrdf,dc=grdf,dc=fr"],"cn":["Hamdi Hamdouss"],"sn":["Hamdouss"],"gidFictif":["y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj"]}';
        $res = $this->serializer->deserialize($jsonData, Person::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => new Person()]);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new SofitNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $lab = $serializer->deserialize($jsonData, Person::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => new Person()]);

//         todo test ok ! fix token injection & base_url injection...
        $this->sofitClient->getExternalUser('y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj');
        $res = $this->sofitClient->getToken();

        dump($res);

        return Command::SUCCESS;
    }

    public function testGdaSerializer()
    {
//                $jsonData = json_encode(['name' => 'CTO']);
        $jsonData = '{"_id":"y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj","_rev":"-1628117453","username":"y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj","realm":"/externeGrdf","uid":["y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj"],"mail":["hamdi.afrit@1985.com"],"universalid":["id=y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj,ou=user,o=externeGrdf,ou=services,dc=openam,dc=forgerock,dc=org"],"givenName":["Hamdi"],"objectClass":["iplanet-am-managed-person","inetuser","sunFederationManagerDataStore","sunFMSAML2NameIdentifier","sunIdentityServerLibertyPPService","inetorgperson","iPlanetPreferences","personnsofit","iplanet-am-user-service","forgerock-am-dashboard-service","organizationalperson","top","sunAMAuthAccountLockout","person","iplanet-am-auth-configuration-service"],"inetUserStatus":["Active"],"dn":["uid=y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj,ou=externeGrdf,dc=grdf,dc=fr"],"cn":["Hamdi Hamdouss"],"sn":["Hamdouss"],"gidFictif":["y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj"]}';
        $res = $this->serializer->deserialize($jsonData, Person::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => new Person()]);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new SofitNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $lab = $serializer->deserialize($jsonData, Person::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => new Person()]);

//         todo test ok ! fix token injection & base_url injection...
        $this->sofitClient->getExternalUser('y8j823659z8qt5695ns577ki328j4fknsi25y9442rf54xn4b25mixaqzy6z52usd8is6899upj');
        $res = $this->sofitClient->getToken();

        dump($res);

        return Command::SUCCESS;
    }







    public function testSerializeAlex()
    {
        $serializer = new Serializer([new ObjectNormalizer()],[new JsonEncoder()]);

        $person1 = new Person();
        $person1->setName('foo');
        $person1->setAge(99);
        $person1->setIdObject(99);

        $person2 = new Person();
        $person2->setName('bar');
        $person2->setAge(33);
        $person2->setIdObject(99);

        $persons = [$person1, $person2];
        $persons2 = new \ArrayObject();
        $persons3 = new ArrayCollection();
        $persons2->append($person2);
        $persons2->append($person1);
        $persons3->add($person1);
        $persons3->add($person2);
//        $persons3->add($person2);
//        $persons3->add($person1);
        $data = $serializer->serialize($persons, 'json');
        $data2 = $serializer->serialize($persons2, 'json');
        $data3 = $serializer->serialize($persons3, 'json');
        dump($data,$data2, $data3);
    }

    public function testDeepStream()
    {
        $stream = $this->getDeepSteam();
        $serializer = new Serializer([new ObjectNormalizer(), new ArrayDenormalizer()], [new JsonEncoder()]);
        $serializer2 = new Serializer([new DeepNormalizer(), new ArrayDenormalizer()], [new JsonEncoder()]);
        $serializer3 = new Serializer([new LabDeepNormalizer(), new ArrayDenormalizer()], [new JsonEncoder()]);
//        $data = json_decode($stream, true)['data'];
        $data = json_decode($stream, true);
//        $data = json_encode($data);
//        dump($data);
//        dump($serializer->deserialize($stream, DeepModel::class, 'json'));
        dump($serializer3->deserialize($stream, DeepModel::class, 'json'));
//        dump($serializer2->denormalize($data, DeepUserModel::class.'[]', 'json'));
        dump($serializer3->denormalize($data, DeepUserModel::class, 'json'));
    }

    public function getDeepSteam()
    {
        return '{"page":2,"per_page":6,"total":12,"total_pages":2,"data":[{"id":7,"email":"michael.lawson@reqres.in","first_name":"Michael","last_name":"Lawson","avatar":"https://reqres.in/img/faces/7-image.jpg"},{"id":8,"email":"lindsay.ferguson@reqres.in","first_name":"Lindsay","last_name":"Ferguson","avatar":"https://reqres.in/img/faces/8-image.jpg"},{"id":9,"email":"tobias.funke@reqres.in","first_name":"Tobias","last_name":"Funke","avatar":"https://reqres.in/img/faces/9-image.jpg"},{"id":10,"email":"byron.fields@reqres.in","first_name":"Byron","last_name":"Fields","avatar":"https://reqres.in/img/faces/10-image.jpg"},{"id":11,"email":"george.edwards@reqres.in","first_name":"George","last_name":"Edwards","avatar":"https://reqres.in/img/faces/11-image.jpg"},{"id":12,"email":"rachel.howell@reqres.in","first_name":"Rachel","last_name":"Howell","avatar":"https://reqres.in/img/faces/12-image.jpg"}],"support":{"url":"https://reqres.in/#support-heading","text":"To keep ReqRes free, contributions towards server costs are appreciated!"}}';
    }
















































    public function testNormalizer()
    {
        $array = [
            'id_accreditation' => '56eb7d43-a76a-4483-8a43-b2090e00ce00',
            'id_internaute' => '2xyt9hhcyzaympyw9hpxfushcsjy29yeuxpzkn0576luxmsg9xcfcxcd6ivwkl5g33me7op97v6',
            'type_objet' => 'eCONSO',
            'id_objet' => '01582296351274',
            'role' => 'DETENTEUR_CONTRAT_FOURNITURE',
            'delai_avant_archivage' => '30',
            'parametres_enrichissement' => [
                'DATEFINPERIODE' => '',
                'CODEPOSTAL' => '77590',
                'DL' => '0',
                'TELERELEVE' => 'Oui',
                'RAISONSOCIALETITULAIRE' => '',
                'STATUTCONTRAT' => 'Actif',
                'DATEDEBUTPERIODE' => '2009-02-01',
                'PCE' => '01582296351274',
                'NUMEROSERIE' => '2010A100922152',
                'RAISONSOCIALEERRONEE' => 'true',
                'MHS' => '',
                'MES' => '2009-02-01',
                'MATRICULECOMPTEUR' => '221',
                'TARIF' => 'T1',
                'NOMTITULAIRE' => 'RELCO-02',
                'NOMTITULAIREERRONE' => 'true',
                'FREQUENCERELEVE' => '1M',
            ],
            'parametres_verification' => [
                'CODEPOSTAL' => '77590',
                'NOMTITULAIRE' => 'compte carma 6M',
            ],
            'donnees_techniques' => [
                'alias' => null,
                'canal_creation' => null,
                'application' => null,
                'id_internaute_referentiel' => null,
                'date_creation' => '2020-11-24 14:50:27',
                'date_premiere_accreditation' => '2020-11-24 14:50:27',
                'date_suppression' => null,
                'date_activation' => '2020-11-24 14:50:27',
                'date_derniere_modification' => null,
                'date_derniere_verification' => '2020-11-24 14:50:27',
                'date_propagation' => '2020-12-12 16:59:52',
                'date_rafraichissement' => '2020-12-12 16:59:52',
                'date_fin_validite' => '2020-11-25 14:50:27',
                'etat' => 'A revérifier',
                'date_revocation' => null,
                'date_passage_a_obsolete' => null,
                'origine_passage_a_obsolete' => null,
                'source_passage_a_obsolete' => null,
                'date_passage_a_refuse' => null,
                'origine_passage_a_refuse' => null,
                'source_passage_a_refuse' => null,
            ],
            'parametres_validation' => [],
            'informations_complementaires' => [],
            'donnees_controle' => [],
        ];


        if ($this->isB()) {

        }

        $serializer = new Serializer([new SofitNormalizer(null, new CamelCaseToSnakeCaseNameConverter())],[new JsonEncoder()]);

        dump($serializer->denormalize($array, Person::class.'[]'));
        die;

        return Command::SUCCESS;
    }

}
