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
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Grdf\SofitBundle\Client\SofitClient;
use Grdf\SofitBundle\Model\SofitUser;
use Doctrine\Common\Collections\ArrayCollection;



class ReccursiveDenormalzationCommand extends Command
{
    protected static $defaultName = 'lab:serializer:cursive';
    protected static $defaultDescription = 'Add a short description for your command';
    private $serializer;
    /**
     * @var ObjectNormalizer
     */
    private $objectNormalizer;

    public function __construct(SerializerInterface $serializer, ObjectNormalizer $objectNormalizer, string $name = null)
    {
        parent::__construct($name);
        $this->serializer = $serializer;
        $this->objectNormalizer = $objectNormalizer;
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
        dd($this->objectNormalizer->denormalize($this->mockArrayStream(), DeepUserModel::class));


        return Command::SUCCESS;
    }

    public function mockArrayStream(): array
    {
        return [
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


    }

}
