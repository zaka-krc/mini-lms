<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Formation;
use App\Models\Chapitre;
use App\Models\SousChapitre;
use App\Models\ContenuPedagogique;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Utilisateurs ────────────────────────────────────────────────────
        $admin = User::create([
            'name'              => 'Administrateur',
            'email'             => 'admin@lms.test',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        $apprenant = User::create([
            'name'              => 'Alice Dupont',
            'email'             => 'alice@lms.test',
            'password'          => Hash::make('password'),
            'role'              => 'apprenant',
            'email_verified_at' => now(),
        ]);

        $apprenant2 = User::create([
            'name'              => 'Bob Martin',
            'email'             => 'bob@lms.test',
            'password'          => Hash::make('password'),
            'role'              => 'apprenant',
            'email_verified_at' => now(),
        ]);

        // ── Formation ───────────────────────────────────────────────────────
        $formation = Formation::create([
            'nom'         => 'Anglais – Les verbes irréguliers',
            'description' => 'Apprendre et mémoriser les verbes irréguliers anglais les plus courants, avec leur forme au prétérit et au participe passé.',
            'niveau'      => 'débutant',
            'duree'       => 4,
        ]);

        // Inscrire les apprenants
        $apprenant->update(['formation_id' => $formation->id]);
        $apprenant2->update(['formation_id' => $formation->id]);

        // ── Chapitre 1 ──────────────────────────────────────────────────────
        $chapitre1 = Chapitre::create([
            'titre'        => 'Comprendre les verbes irréguliers',
            'description'  => 'Introduction aux verbes irréguliers en anglais et leur fonctionnement.',
            'formation_id' => $formation->id,
            'ordre'        => 1,
        ]);

        $sc1_1 = SousChapitre::create([
            'titre'       => 'Qu\'est-ce qu\'un verbe irrégulier ?',
            'contenu'     => "En anglais, la plupart des verbes forment leur prétérit (passé simple) et leur participe passé en ajoutant **-ed** à la base verbale. Ce sont les verbes réguliers.\n\nExemples :\n- work → worked → worked\n- play → played → played\n\nMais certains verbes ne suivent pas cette règle : leurs formes changent de façon imprévisible. On les appelle les **verbes irréguliers**.\n\nExemples :\n- go → went → gone\n- be → was/were → been\n- have → had → had\n\nIl est indispensable de les mémoriser, car ils sont parmi les plus utilisés en anglais.",
            'chapitre_id' => $chapitre1->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Définition et importance des verbes irréguliers',
            'texte'            => "Un verbe irrégulier est un verbe dont les formes conjuguées (prétérit et participe passé) ne peuvent pas être déduites par simple ajout de -ed.\n\nPourquoi sont-ils importants ?\n• Ils font partie des verbes les plus fréquents de la langue anglaise.\n• On les retrouve dans la conversation, dans les textes écrits, à l'oral et dans les médias.\n• Les maîtriser permet d'éviter des erreurs courantes comme \"I goed\" au lieu de \"I went\".\n\nStratégie d'apprentissage :\nApprenez-les par groupe de 5 à 10, en vous concentrant d'abord sur les plus utilisés. Associez chaque verbe à une phrase de contexte pour mieux mémoriser.",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $sc1_1->id,
        ]);

        $sc1_2 = SousChapitre::create([
            'titre'       => '10 verbes irréguliers indispensables',
            'contenu'     => "Voici les 10 verbes irréguliers les plus courants en anglais :\n\n| Infinitif | Prétérit | Participe passé | Traduction |\n|-----------|----------|-----------------|------------|\n| be        | was/were | been            | être       |\n| have      | had      | had             | avoir      |\n| do        | did      | done            | faire      |\n| go        | went     | gone            | aller      |\n| get       | got      | got/gotten      | obtenir    |\n| make      | made     | made            | faire      |\n| say       | said     | said            | dire       |\n| know      | knew     | known           | savoir     |\n| think     | thought  | thought         | penser     |\n| come      | came     | come            | venir      |\n\nAstuce : répétez-les à voix haute : base → prétérit → participe passé.",
            'chapitre_id' => $chapitre1->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Tableau des 10 verbes clés',
            'texte'            => "be / was / been\nhave / had / had\ndo / did / done\ngo / went / gone\nget / got / got\nmake / made / made\nsay / said / said\nknow / knew / known\nthink / thought / thought\ncome / came / come\n\nExercice de mémorisation :\nCouvrez la colonne « prétérit » et essayez de retrouver les formes de mémoire. Faites de même avec la colonne « participe passé ».",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $sc1_2->id,
        ]);

        // ── Chapitre 2 ──────────────────────────────────────────────────────
        $chapitre2 = Chapitre::create([
            'titre'        => 'Méthodes de mémorisation',
            'description'  => 'Techniques efficaces pour retenir les verbes irréguliers.',
            'formation_id' => $formation->id,
            'ordre'        => 2,
        ]);

        $sc2_1 = SousChapitre::create([
            'titre'       => 'Techniques pour retenir les verbes irréguliers',
            'contenu'     => "Voici plusieurs techniques éprouvées pour mémoriser les verbes irréguliers :\n\n**1. Apprentissage par groupes de sons**\nRegroupez les verbes dont les formes sonnent pareil :\n- ring → rang → rung / sing → sang → sung / swim → swam → swum\n\n**2. Cartes mémoire (flashcards)**\nÉcrivez l'infinitif d'un côté, les formes conjuguées de l'autre. Révisez régulièrement.\n\n**3. La répétition espacée**\nRévisez un verbe le lendemain, puis 3 jours après, puis 1 semaine après. Cette méthode renforce la mémoire à long terme.\n\n**4. Utilisation en contexte**\nCréez des phrases courtes avec chaque verbe :\n- Yesterday I **went** to school.\n- She **had** a dream.\n\n**5. Chansons et rimes**\nCertains professeurs mettent les verbes irréguliers en musique. C'est une méthode amusante et efficace.",
            'chapitre_id' => $chapitre2->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Guide des méthodes de mémorisation',
            'texte'            => "Résumé des 5 techniques :\n1. Groupes de sons similaires (ring/sing/swim)\n2. Flashcards recto/verso\n3. Répétition espacée (J+1, J+3, J+7)\n4. Phrases de contexte personnelles\n5. Chansons et rimes mnémotechniques\n\nRecommandation : combinez au moins 2 techniques pour des résultats durables.",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $sc2_1->id,
        ]);

        // ── Quiz 1 ──────────────────────────────────────────────────────────
        $quiz1 = Quiz::create([
            'titre'            => 'Quiz – Les prétérits irréguliers',
            'sous_chapitre_id' => $sc1_2->id,
        ]);

        $questionsQuiz1 = [
            [
                'texte'    => 'Quel est le prétérit de "go" ?',
                'reponses' => [
                    ['texte' => 'goed',   'est_correcte' => false],
                    ['texte' => 'went',   'est_correcte' => true],
                    ['texte' => 'gone',   'est_correcte' => false],
                    ['texte' => 'goes',   'est_correcte' => false],
                ],
            ],
            [
                'texte'    => 'Quel est le prétérit de "have" ?',
                'reponses' => [
                    ['texte' => 'haved',  'est_correcte' => false],
                    ['texte' => 'has',    'est_correcte' => false],
                    ['texte' => 'had',    'est_correcte' => true],
                    ['texte' => 'have',   'est_correcte' => false],
                ],
            ],
            [
                'texte'    => 'Quel est le prétérit de "do" ?',
                'reponses' => [
                    ['texte' => 'does',   'est_correcte' => false],
                    ['texte' => 'done',   'est_correcte' => false],
                    ['texte' => 'doed',   'est_correcte' => false],
                    ['texte' => 'did',    'est_correcte' => true],
                ],
            ],
            [
                'texte'    => 'Quel est le prétérit de "know" ?',
                'reponses' => [
                    ['texte' => 'known',  'est_correcte' => false],
                    ['texte' => 'knowed', 'est_correcte' => false],
                    ['texte' => 'knew',   'est_correcte' => true],
                    ['texte' => 'knows',  'est_correcte' => false],
                ],
            ],
            [
                'texte'    => 'Quel est le prétérit de "think" ?',
                'reponses' => [
                    ['texte' => 'thinked',  'est_correcte' => false],
                    ['texte' => 'thought',  'est_correcte' => true],
                    ['texte' => 'thinkt',   'est_correcte' => false],
                    ['texte' => 'thinks',   'est_correcte' => false],
                ],
            ],
            [
                'texte'    => 'Quel est le prétérit de "make" ?',
                'reponses' => [
                    ['texte' => 'maked',  'est_correcte' => false],
                    ['texte' => 'makes',  'est_correcte' => false],
                    ['texte' => 'made',   'est_correcte' => true],
                    ['texte' => 'maid',   'est_correcte' => false],
                ],
            ],
            [
                'texte'    => 'Quel est le prétérit de "come" ?',
                'reponses' => [
                    ['texte' => 'comed',  'est_correcte' => false],
                    ['texte' => 'came',   'est_correcte' => true],
                    ['texte' => 'come',   'est_correcte' => false],
                    ['texte' => 'comes',  'est_correcte' => false],
                ],
            ],
            [
                'texte'    => 'Quel est le participe passé de "go" ?',
                'reponses' => [
                    ['texte' => 'went',  'est_correcte' => false],
                    ['texte' => 'goed',  'est_correcte' => false],
                    ['texte' => 'gone',  'est_correcte' => true],
                    ['texte' => 'going', 'est_correcte' => false],
                ],
            ],
        ];

        foreach ($questionsQuiz1 as $qData) {
            $question = Question::create([
                'texte'   => $qData['texte'],
                'quiz_id' => $quiz1->id,
            ]);

            foreach ($qData['reponses'] as $rData) {
                Reponse::create([
                    'texte'       => $rData['texte'],
                    'est_correcte' => $rData['est_correcte'],
                    'question_id' => $question->id,
                ]);
            }
        }

        // ── Quiz 2 ──────────────────────────────────────────────────────────
        $quiz2 = Quiz::create([
            'titre'            => 'Quiz – Vrai ou Faux sur les irréguliers',
            'sous_chapitre_id' => $sc1_1->id,
        ]);

        $questionsQuiz2 = [
            [
                'texte'    => 'Le prétérit de "say" est "said".',
                'reponses' => [
                    ['texte' => 'Vrai',  'est_correcte' => true],
                    ['texte' => 'Faux',  'est_correcte' => false],
                ],
            ],
            [
                'texte'    => 'Le prétérit de "get" est "getted".',
                'reponses' => [
                    ['texte' => 'Vrai',  'est_correcte' => false],
                    ['texte' => 'Faux',  'est_correcte' => true],
                ],
            ],
            [
                'texte'    => 'Les verbes réguliers forment leur prétérit en ajoutant -ed.',
                'reponses' => [
                    ['texte' => 'Vrai',  'est_correcte' => true],
                    ['texte' => 'Faux',  'est_correcte' => false],
                ],
            ],
        ];

        foreach ($questionsQuiz2 as $qData) {
            $question = Question::create([
                'texte'   => $qData['texte'],
                'quiz_id' => $quiz2->id,
            ]);

            foreach ($qData['reponses'] as $rData) {
                Reponse::create([
                    'texte'        => $rData['texte'],
                    'est_correcte' => $rData['est_correcte'],
                    'question_id'  => $question->id,
                ]);
            }
        }

        // ════════════════════════════════════════════════════════════════════
        // FORMATION 2 – JoJo's Bizarre Adventure
        // ════════════════════════════════════════════════════════════════════
        $jojoFormation = Formation::create([
            'nom'         => "JoJo's Bizarre Adventure – L'univers complet",
            'description' => "Plongez dans l'œuvre monumentale d'Hirohiko Araki. De Phantom Blood à Steel Ball Run, explorez les parties, les personnages, les Stands et les antagonistes légendaires de l'une des séries manga les plus influentes de tous les temps.",
            'niveau'      => 'intermédiaire',
            'duree'       => 6,
        ]);

        // ── Chapitre 1 – Introduction ────────────────────────────────────────
        $jojoCh1 = Chapitre::create([
            'titre'        => "Introduction à JoJo's Bizarre Adventure",
            'description'  => "Découvrez les origines de la série, son auteur et ce qui la rend si unique dans le paysage du manga.",
            'formation_id' => $jojoFormation->id,
            'ordre'        => 1,
        ]);

        $jojoSc1_1 = SousChapitre::create([
            'titre'       => "C'est quoi JoJo's Bizarre Adventure ?",
            'contenu'     => "**JoJo's Bizarre Adventure** (ジョジョの奇妙な冒険) est un manga seinen créé par **Hirohiko Araki**, publié depuis **1987** dans le magazine Weekly Shonen Jump puis dans Ultra Jump.\n\nLa série se distingue par :\n- Une narration en **plusieurs parties indépendantes**, chacune avec un protagoniste différent portant le surnom « JoJo ».\n- Un système de pouvoirs unique : d'abord le **Hamon** (énergie solaire), puis les **Stands** (manifestations de l'âme).\n- Un style visuel **flamboyant et théâtral**, fortement inspiré de la mode et des poses artistiques.\n- Des références culturelles profondes (musique, peinture, mythologie).\n\nAvec plus de **100 millions d'exemplaires** vendus dans le monde, JoJo est l'une des séries les plus longues et influentes de l'histoire du manga.",
            'chapitre_id' => $jojoCh1->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => "Fiche de présentation – JoJo's Bizarre Adventure",
            'texte'            => "Titre original : ジョジョの奇妙な冒険\nAuteur : Hirohiko Araki\nDébut de publication : 1987\nMagazine : Weekly Shonen Jump (P1-P6), Ultra Jump (P7-P9)\nGenre : Shonen / Seinen, Action, Aventure, Horreur\nNombre de volumes : 130+ (en cours)\nAdaptation anime : 2012 (David Production)\n\nThèmes récurrents :\n• La lignée familiale et l'héritage\n• Le destin contre le libre arbitre\n• La volonté de surmonter l'impossible\n• La mode et l'esthétique comme forme de puissance",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $jojoSc1_1->id,
        ]);

        $jojoSc1_2 = SousChapitre::create([
            'titre'       => 'Hirohiko Araki – L\'auteur derrière la légende',
            'contenu'     => "**Hirohiko Araki** est né le **7 juin 1960** à Sendai, au Japon. Il a débuté sa carrière de mangaka en 1980 avec *Poker Under Arms*.\n\n**Son style inimitable** :\n- Inspiré par la **peinture occidentale** (Renaissance, Art nouveau) et les **magazines de mode** (Vogue, GQ).\n- Les poses de ses personnages sont volontairement théâtrales et défient souvent l'anatomie réaliste.\n- Il est fasciné par les **musiques rock et pop** : presque tous les noms de personnages et de Stands sont des références musicales (Dio, Giorno Giovanna, King Crimson…).\n\n**Citations célèbres d'Araki** :\n> « La chose la plus importante dans un manga, c'est de transmettre de l'émotion. »\n> « Je ne dessine pas des monstres, je dessine des humains sous une pression extrême. »\n\nAraki est connu pour **ne pas vieillir** — une blague récurrente dans la communauté des fans qui affirme qu'il est lui-même un vampire.",
            'chapitre_id' => $jojoCh1->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Influences artistiques d\'Araki',
            'texte'            => "Influences visuelles :\n• Michelangelo, Botticelli (poses et proportions)\n• Alphonse Mucha (Art nouveau, arabesques)\n• Magazines de mode (silhouettes, vêtements extravagants)\n\nInfluences musicales (noms de personnages) :\n• Dio → Dio (groupe heavy metal)\n• Giorno Giovanna → Giorgio par Moroder\n• King Crimson → King Crimson (groupe prog-rock)\n• Killer Queen → Queen\n• Crazy Diamond → Pink Floyd\n\nInfluences narratives :\n• Films d'horreur de série B\n• Romances gothiques européennes\n• Shonen Jump (dépassement de soi, amitié)",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $jojoSc1_2->id,
        ]);

        $jojoQuiz1 = Quiz::create([
            'titre'            => 'Quiz – Les bases de JoJo',
            'sous_chapitre_id' => $jojoSc1_1->id,
        ]);

        $jojoQuestionsQuiz1 = [
            [
                'texte'    => "En quelle année JoJo's Bizarre Adventure a-t-il été publié pour la première fois ?",
                'reponses' => [
                    ['texte' => '1980', 'est_correcte' => false],
                    ['texte' => '1987', 'est_correcte' => true],
                    ['texte' => '1993', 'est_correcte' => false],
                    ['texte' => '2000', 'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Quel est le nom de l'auteur de JoJo's Bizarre Adventure ?",
                'reponses' => [
                    ['texte' => 'Akira Toriyama',    'est_correcte' => false],
                    ['texte' => 'Eiichiro Oda',      'est_correcte' => false],
                    ['texte' => 'Hirohiko Araki',    'est_correcte' => true],
                    ['texte' => 'Masashi Kishimoto', 'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Quel système de pouvoirs apparaît à partir de la Partie 3 ?",
                'reponses' => [
                    ['texte' => 'Le Hamon',   'est_correcte' => false],
                    ['texte' => 'Les Stands', 'est_correcte' => true],
                    ['texte' => 'Le Spin',    'est_correcte' => false],
                    ['texte' => 'Le Chakra',  'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Combien d'exemplaires JoJo's Bizarre Adventure a-t-il vendus dans le monde ?",
                'reponses' => [
                    ['texte' => '10 millions',  'est_correcte' => false],
                    ['texte' => '50 millions',  'est_correcte' => false],
                    ['texte' => '100 millions', 'est_correcte' => true],
                    ['texte' => '200 millions', 'est_correcte' => false],
                ],
            ],
        ];

        foreach ($jojoQuestionsQuiz1 as $jojoQData) {
            $jojoQ = Question::create(['texte' => $jojoQData['texte'], 'quiz_id' => $jojoQuiz1->id]);
            foreach ($jojoQData['reponses'] as $jojoR) {
                Reponse::create(['texte' => $jojoR['texte'], 'est_correcte' => $jojoR['est_correcte'], 'question_id' => $jojoQ->id]);
            }
        }

        // ── Chapitre 2 – Les Parties ─────────────────────────────────────────
        $jojoCh2 = Chapitre::create([
            'titre'        => 'Les Parties et leurs protagonistes',
            'description'  => "De Jonathan Joestar à Josuke Higashikata, explorez chaque arc narratif et le JoJo qui en est le héros.",
            'formation_id' => $jojoFormation->id,
            'ordre'        => 2,
        ]);

        $jojoSc2_1 = SousChapitre::create([
            'titre'       => 'Partie 1 & 2 : Phantom Blood et Battle Tendency',
            'contenu'     => "## Partie 1 – Phantom Blood (1987–1988)\n**Protagoniste : Jonathan Joestar (JoJo)**\n**Époque : Angleterre victorienne, 1880**\n\nJonathan, jeune aristocrate noble et courageux, voit sa vie bouleversée par l'arrivée de **Dio Brando**, un orphelin ambitieux et cruel que son père a adopté. Dio cherche à s'emparer de la fortune des Joestar et devient finalement un **vampire** grâce au masque en pierre.\n\nSystème de pouvoir : le **Hamon** (Onde Sénégale), une énergie solaire transmise par la respiration, efficace contre les vampires.\n\n---\n\n## Partie 2 – Battle Tendency (1988–1989)\n**Protagoniste : Joseph Joestar (JoJo), petit-fils de Jonathan**\n**Époque : New York et Europe, 1938–1939**\n\nJoseph, espiègle et charismatique, affronte les **Hommes du Pilier** — des êtres ancestraux à la puissance terrifiante : Santana, Wamuu, Esidisi et **Kars**, leur chef, qui cherche à devenir l'Être Ultime.\n\nLe Hamon atteint son apogée dans cette partie, combiné à des stratégies rusées de Joseph.",
            'chapitre_id' => $jojoCh2->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Fiche personnages – Parties 1 & 2',
            'texte'            => "PARTIE 1 :\n• Jonathan Joestar – Héros noble et généreux, symbole de justice\n• Dio Brando – Antagoniste principal, futur vampire\n• Robert E. O. Speedwagon – Ami fidèle de Jonathan, narrateur moral de la série\n• William Anthonio Zeppeli – Maître du Hamon de Jonathan\n\nPARTIE 2 :\n• Joseph Joestar – Combattant imprévisible et inventif\n• Caesar Anthonio Zeppeli – Rival/ami de Joseph, petit-fils de Zeppeli\n• Lisa Lisa – Maître du Hamon, figure mystérieuse\n• Kars – Chef des Hommes du Pilier, devient l'Être Ultime\n• Wamuu – Antagoniste honorable, rival direct de Joseph",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $jojoSc2_1->id,
        ]);

        $jojoSc2_2 = SousChapitre::create([
            'titre'       => 'Partie 3 & 4 : Stardust Crusaders et Diamond is Unbreakable',
            'contenu'     => "## Partie 3 – Stardust Crusaders (1989–1992)\n**Protagoniste : Jotaro Kujo (JoJo), petit-fils de Joseph**\n**Époque : Japon → Égypte, 1988**\n\nDio Brando, ressuscité avec le corps de Jonathan, est en Égypte. Sa puissance grandit et menace la vie de Holly Kujo, mère de Jotaro. Avec ses alliés (**les Croisés**), Jotaro traverse l'Asie et l'Afrique pour affronter Dio.\n\nIntroduction des **Stands** : chaque personnage possède une manifestation de son âme avec un pouvoir unique.\n\nStand de Jotaro : **Star Platinum** — force et vitesse surhumaines, capable d'**arrêter le temps** (Za Warudo).\n\n---\n\n## Partie 4 – Diamond is Unbreakable (1992–1995)\n**Protagoniste : Josuke Higashikata (JoJo), fils illégitime de Joseph**\n**Époque : Morioh, Japon, 1999**\n\nMorioh est une petite ville paisible... jusqu'à l'apparition d'un tueur en série masqué. Josuke et ses amis doivent trouver **Kira Yoshikage**, un meurtrier obsessionnel qui vit dans l'ombre.\n\nStand de Josuke : **Crazy Diamond** — capable de **réparer** et reconstituer tout ce qu'il touche.",
            'chapitre_id' => $jojoCh2->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Fiche personnages – Parties 3 & 4',
            'texte'            => "PARTIE 3 :\n• Jotaro Kujo – Stand : Star Platinum | Personnage le plus emblématique de la série\n• Joseph Joestar – Stand : Hermit Purple | Reprend du service\n• Muhammad Avdol – Stand : Magician's Red\n• Noriaki Kakyoin – Stand : Hierophant Green\n• Jean-Pierre Polnareff – Stand : Silver Chariot\n• Iggy – Stand : The Fool\n• DIO – Stand : The World (Za Warudo) | Arrête le temps\n\nPARTIE 4 :\n• Josuke Higashikata – Stand : Crazy Diamond (réparation)\n• Koichi Hirose – Stand : Echoes (évolue en 3 actes)\n• Okuyasu Nijimura – Stand : The Hand (efface l'espace)\n• Rohan Kishibe – Stand : Heaven's Door (écrit dans les gens)\n• Kira Yoshikage – Stand : Killer Queen (transforme en bombe)",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $jojoSc2_2->id,
        ]);

        $jojoSc2_3 = SousChapitre::create([
            'titre'       => 'Parties 5, 6 & 7 : Golden Wind, Stone Ocean, Steel Ball Run',
            'contenu'     => "## Partie 5 – Golden Wind (1995–1999)\n**Protagoniste : Giorno Giovanna (GioGio), fils de DIO**\n**Époque : Naples, Italie, 2001**\n\nGiorno rêve de devenir un **Gang-Star** — non par cupidité, mais pour purifier la mafia italienne de la drogue. Il intègre le Passione, le gang dirigé par le mystérieux **Boss** dont personne ne connaît le visage.\n\nStand : **Gold Experience** → **Gold Experience Requiem** (le Stand le plus puissant de la série).\n\n---\n\n## Partie 6 – Stone Ocean (1999–2003)\n**Protagoniste : Jolyne Cujoh (JoJo), fille de Jotaro**\n**Époque : Prison de Green Dolphin Street, Floride, 2011**\n\nPremière protagoniste féminine de la série. Emprisonnée injustement, Jolyne doit survivre en prison tout en affrontant les disciples de DIO.\n\nStand : **Stone Free** — transforme son corps en fils.\n\n---\n\n## Partie 7 – Steel Ball Run (2004–2011)\n**Protagoniste : Johnny Joestar, dans une réalité alternative**\n**Époque : Amérique, 1890 — Grande course transcontinentale**\n\nUnivers alternatif. Johnny, ancien jockey paralysé, participe à une course à cheval de New York à San Diego. Il rencontre **Gyro Zeppeli**, maître du **Spin**, une technique basée sur la rotation parfaite.\n\nStand : **Tusk** (évolue jusqu'à l'Acte 4).",
            'chapitre_id' => $jojoCh2->id,
            'ordre'       => 3,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Tableau récapitulatif des 7 parties',
            'texte'            => "Partie | Titre                  | JoJo               | Époque    | Lieu\n1      | Phantom Blood          | Jonathan Joestar   | 1880      | Angleterre\n2      | Battle Tendency        | Joseph Joestar     | 1938–39   | USA / Europe\n3      | Stardust Crusaders     | Jotaro Kujo        | 1988      | Japon → Égypte\n4      | Diamond is Unbreakable | Josuke Higashikata | 1999      | Morioh, Japon\n5      | Golden Wind            | Giorno Giovanna    | 2001      | Italie\n6      | Stone Ocean            | Jolyne Cujoh       | 2011      | Floride, USA\n7      | Steel Ball Run         | Johnny Joestar     | 1890      | USA (univers alt.)",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $jojoSc2_3->id,
        ]);

        $jojoQuiz2 = Quiz::create([
            'titre'            => 'Quiz – Les protagonistes de JoJo',
            'sous_chapitre_id' => $jojoSc2_2->id,
        ]);

        $jojoQuestionsQuiz2 = [
            [
                'texte'    => "Quel est le Stand de Jotaro Kujo ?",
                'reponses' => [
                    ['texte' => 'The World',       'est_correcte' => false],
                    ['texte' => 'Star Platinum',   'est_correcte' => true],
                    ['texte' => 'Crazy Diamond',   'est_correcte' => false],
                    ['texte' => 'Gold Experience', 'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Qui est la première protagoniste féminine de JoJo's Bizarre Adventure ?",
                'reponses' => [
                    ['texte' => 'Lisa Lisa',    'est_correcte' => false],
                    ['texte' => 'Trish Una',    'est_correcte' => false],
                    ['texte' => 'Jolyne Cujoh', 'est_correcte' => true],
                    ['texte' => 'Lucy Steel',   'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Dans quelle ville se déroule la Partie 4 (Diamond is Unbreakable) ?",
                'reponses' => [
                    ['texte' => 'Tokyo',  'est_correcte' => false],
                    ['texte' => 'Osaka',  'est_correcte' => false],
                    ['texte' => 'Morioh', 'est_correcte' => true],
                    ['texte' => 'Kyoto',  'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Quel personnage est le fils de DIO ?",
                'reponses' => [
                    ['texte' => 'Jotaro Kujo',       'est_correcte' => false],
                    ['texte' => 'Josuke Higashikata', 'est_correcte' => false],
                    ['texte' => 'Giorno Giovanna',    'est_correcte' => true],
                    ['texte' => 'Diavolo',            'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Quel système de pouvoir utilise-t-on dans les Parties 1 et 2 ?",
                'reponses' => [
                    ['texte' => 'Les Stands', 'est_correcte' => false],
                    ['texte' => 'Le Spin',    'est_correcte' => false],
                    ['texte' => 'Le Hamon',   'est_correcte' => true],
                    ['texte' => 'La Volonté', 'est_correcte' => false],
                ],
            ],
        ];

        foreach ($jojoQuestionsQuiz2 as $jojoQData) {
            $jojoQ = Question::create(['texte' => $jojoQData['texte'], 'quiz_id' => $jojoQuiz2->id]);
            foreach ($jojoQData['reponses'] as $jojoR) {
                Reponse::create(['texte' => $jojoR['texte'], 'est_correcte' => $jojoR['est_correcte'], 'question_id' => $jojoQ->id]);
            }
        }

        // ── Chapitre 3 – Les Stands ──────────────────────────────────────────
        $jojoCh3 = Chapitre::create([
            'titre'        => 'Le Système des Stands',
            'description'  => "Comprenez ce qui rend JoJo unique : les Stands, manifestations de l'énergie spirituelle des personnages.",
            'formation_id' => $jojoFormation->id,
            'ordre'        => 3,
        ]);

        $jojoSc3_1 = SousChapitre::create([
            'titre'       => "Qu'est-ce qu'un Stand ?",
            'contenu'     => "Un **Stand** est la manifestation physique ou psychique de l'énergie spirituelle d'un individu. Il représente littéralement « ce sur quoi on s'appuie » (d'où le nom anglais *stand*, dans le sens de « tenir ferme »).\n\n**Caractéristiques générales :**\n- Un Stand n'est visible que par les autres utilisateurs de Stand.\n- Il est lié à son utilisateur : toute blessure infligée au Stand se répercute sur son propriétaire (et vice versa).\n- Chaque Stand a un **pouvoir unique**, souvent basé sur un concept ou une métaphore.\n- Les Stands sont nommés d'après des **artistes musicaux ou albums** : Star Platinum, The World, Killer Queen, King Crimson…\n\n**Comment acquiert-on un Stand ?**\n- En étant exposé à la **Flèche Stand** (une flèche d'origine mystérieuse).\n- Par héritage génétique (les Joestar en sont prédisposés).\n- Dans certains cas, par une expérience traumatisante intense.\n\n**Les catégories de Stands :**\n| Type        | Description |\n|-------------|-------------|\n| Humanoïde   | Forme humanoïde, puissants au corps à corps |\n| Long Range  | Agissent à distance |\n| Automatique | Agissent indépendamment |\n| Objet       | Prennent la forme d'un objet |\n| Lié         | Fusionnent avec un objet ou un être vivant |",
            'chapitre_id' => $jojoCh3->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Les statistiques d\'un Stand',
            'texte'            => "Chaque Stand est évalué selon 6 critères dans le manga :\n\n• Destructive Power (Puissance destructive) : A à E\n• Speed (Vitesse) : A à E\n• Range (Portée) : A à E\n• Durability (Endurance) : A à E\n• Precision (Précision) : A à E\n• Developmental Potential (Potentiel d'évolution) : A à E\n\nExemple — Star Platinum :\nPuissance : A | Vitesse : A | Portée : C | Endurance : A | Précision : A | Potentiel : A\n\nCes stats permettent d'équilibrer les combats : un Stand avec des stats moyennes peut compenser par une stratégie intelligente.",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $jojoSc3_1->id,
        ]);

        $jojoSc3_2 = SousChapitre::create([
            'titre'       => 'Les Stands les plus iconiques',
            'contenu'     => "## Star Platinum — Jotaro Kujo\nStand humanoïde de force et vitesse maximales. Capacité ultime : **Za Warudo** (arrêt du temps jusqu'à 5 secondes).\n\n## The World — DIO\nQuasi identique à Star Platinum dans l'apparence. Capacité : **Za Warudo** (arrêt du temps jusqu'à 9 secondes). Symbole de la domination absolue.\n\n## Crazy Diamond — Josuke Higashikata\nCapacité de **réparation et reconstitution**. Peut réparer les objets, les blessures des autres (pas les siennes), et même reconstituer un être vivant explosé.\n\n## Gold Experience Requiem — Giorno Giovanna\nLe Stand obtenu après que Gold Experience soit touché par la Flèche Stand Requiem. Capacité : **remettre à zéro la réalité**. Tout acte dirigé contre Giorno est annulé — ses ennemis revivent leur mort à l'infini.\n\n## Killer Queen — Kira Yoshikage\nTransforme tout ce qu'il touche en **bombe**. Trois capacités : Sheer Heart Attack (bombe autonome thermoguidée), Bites the Dust (bombe temporelle), et la bombe primaire.\n\n## King Crimson — Diavolo\nCapacité de **supprimer le temps** : Diavolo efface quelques secondes de la réalité et peut voir l'avenir. Les événements se produisent, mais personne ne s'en souvient.",
            'chapitre_id' => $jojoCh3->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Tableau des Stands iconiques',
            'texte'            => "Stand                   | Utilisateur         | Pouvoir principal\nStar Platinum           | Jotaro Kujo         | Force/vitesse + arrêt du temps\nThe World               | DIO                 | Arrêt du temps (9 sec)\nCrazy Diamond           | Josuke Higashikata  | Réparation de tout\nGold Experience Requiem | Giorno Giovanna     | Annulation de la réalité\nKiller Queen            | Kira Yoshikage      | Transformation en bombe\nKing Crimson            | Diavolo             | Effacement du temps\nStone Free              | Jolyne Cujoh        | Corps en fils\nTusk Act 4              | Johnny Joestar      | Rotation infinie",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $jojoSc3_2->id,
        ]);

        $jojoQuiz3 = Quiz::create([
            'titre'            => 'Quiz – Les Stands',
            'sous_chapitre_id' => $jojoSc3_1->id,
        ]);

        $jojoQuestionsQuiz3 = [
            [
                'texte'    => "Quel est le pouvoir du Stand 'Crazy Diamond' ?",
                'reponses' => [
                    ['texte' => 'Arrêter le temps',        'est_correcte' => false],
                    ['texte' => 'Réparer et reconstituer', 'est_correcte' => true],
                    ['texte' => 'Transformer en bombe',    'est_correcte' => false],
                    ['texte' => 'Effacer le temps',        'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Qui utilise le Stand 'The World' (Za Warudo) ?",
                'reponses' => [
                    ['texte' => 'Jotaro',  'est_correcte' => false],
                    ['texte' => 'Giorno',  'est_correcte' => false],
                    ['texte' => 'DIO',     'est_correcte' => true],
                    ['texte' => 'Diavolo', 'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Combien de critères d'évaluation possède un Stand ?",
                'reponses' => [
                    ['texte' => '3', 'est_correcte' => false],
                    ['texte' => '4', 'est_correcte' => false],
                    ['texte' => '5', 'est_correcte' => false],
                    ['texte' => '6', 'est_correcte' => true],
                ],
            ],
            [
                'texte'    => "Quelle est la capacité de 'Gold Experience Requiem' ?",
                'reponses' => [
                    ['texte' => 'Lire dans les esprits',       'est_correcte' => false],
                    ['texte' => 'Remettre à zéro la réalité',  'est_correcte' => true],
                    ['texte' => 'Voler les pouvoirs adverses', 'est_correcte' => false],
                    ['texte' => 'Dupliquer les objets',        'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Vrai ou Faux : les dégâts subis par un Stand se répercutent sur son utilisateur.",
                'reponses' => [
                    ['texte' => 'Vrai — les dégâts sont mutuels',  'est_correcte' => true],
                    ['texte' => 'Faux — le Stand est indépendant', 'est_correcte' => false],
                ],
            ],
        ];

        foreach ($jojoQuestionsQuiz3 as $jojoQData) {
            $jojoQ = Question::create(['texte' => $jojoQData['texte'], 'quiz_id' => $jojoQuiz3->id]);
            foreach ($jojoQData['reponses'] as $jojoR) {
                Reponse::create(['texte' => $jojoR['texte'], 'est_correcte' => $jojoR['est_correcte'], 'question_id' => $jojoQ->id]);
            }
        }

        // ── Chapitre 4 – Les Antagonistes ───────────────────────────────────
        $jojoCh4 = Chapitre::create([
            'titre'        => 'Les Antagonistes légendaires',
            'description'  => "JoJo doit une grande partie de sa renommée à ses antagonistes mémorables. Découvrez les grands vilains de la série.",
            'formation_id' => $jojoFormation->id,
            'ordre'        => 4,
        ]);

        $jojoSc4_1 = SousChapitre::create([
            'titre'       => 'DIO Brando – L\'antagoniste ultime',
            'contenu'     => "**DIO Brando** est sans doute l'antagoniste le plus emblématique de tout le manga shonen. Présent dès la Partie 1, son ombre plane sur les Parties 1, 3 et 6.\n\n**Origines :**\nFils d'un père alcoolique violent dans l'Angleterre victorienne, Dio développe très tôt une philosophie selon laquelle seuls les dominants méritent de vivre. Son ambition est de « surpasser tous les humains ».\n\n**Évolution :**\n- **Partie 1** : Utilise le Masque en Pierre pour devenir un vampire. Affronte Jonathan Joestar, qui meurt en le vainquant.\n- **Partie 3** : Ressuscité après un siècle, il s'est greffé le corps de Jonathan. Il développe le Stand **The World** et réunit une armée de Stand Users pour tuer les Joestar.\n\n**Philosophie :**\nDIO est fascinant car il incarne une logique interne cohérente : le monde est cruel, donc seule la puissance compte. Son discours sur le **destin** et la **domination** est toujours articulé avec intelligence.\n\n**Répliques célèbres :**\n> « MUDA MUDA MUDA MUDA ! » (Inutile, inutile !)\n> « ZA WARUDO ! TOKI WO TOMARE ! » (Le Monde ! Arrête le temps !)",
            'chapitre_id' => $jojoCh4->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Analyse du personnage de DIO',
            'texte'            => "Archétype : le surhomme nietzschéen mal interprété\nMotivation : domination absolue, transcendance de l'humain\nFaiblesses : arrogance, sous-estimation des Joestar, lumière solaire (Partie 1)\n\nSymbolisme :\n• Son nom (DIO = Dieu en italien) reflète son désir de divinité\n• Le corps de Jonathan qu'il porte symbolise la corruption du bien par le mal\n• Za Warudo (arrêt du temps) = métaphore du contrôle absolu\n\nHéritage dans la série :\n• Ses descendants et disciples sont les antagonistes des Parties 5 et 6\n• Enrico Pucci (Partie 6) cherche à réaliser le « Paradis » que DIO avait prévu",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $jojoSc4_1->id,
        ]);

        $jojoSc4_2 = SousChapitre::create([
            'titre'       => 'Kira Yoshikage, Diavolo et les autres grands vilains',
            'contenu'     => "## Kira Yoshikage (Partie 4)\nKira est un tueur en série qui vit à Morioh sous une identité banale. Il ne désire qu'une chose : **une vie calme**. Mais sa pulsion meurtrière le pousse à tuer des femmes pour leur couper les mains.\n\nSon Stand **Killer Queen** transforme tout ce qu'il touche en bombe. C'est l'un des Stands les plus versatiles et redoutables de la série.\n\nCe qui rend Kira unique : il n'est pas un conquérant ou un idéologue. C'est un homme ordinaire avec une obsession maladive. Sa **banalité** le rend d'autant plus effrayant.\n\n---\n\n## Diavolo (Partie 5)\nChef du Passione, le syndicat criminel italien. Son identité est totalement inconnue — même ses plus proches lieutenants ne connaissent pas son visage.\n\nSon Stand **King Crimson** lui permet d'effacer des secondes du temps et de voir l'avenir. Il écrase quiconque tente de connaître son passé.\n\nDiavolo incarne la **paranoïa du pouvoir** : sa force est réelle, mais sa peur d'être découvert le ronge.\n\n---\n\n## Enrico Pucci (Partie 6)\nPrêtre catholique et ami de DIO. Il cherche à accomplir le « Paradis » — une réinitialisation de l'univers. Son Stand **Whitesnake** évolue en **C-Moon**, puis en **Made in Heaven**, accélérant le temps jusqu'à l'infini.\n\nPucci représente la foi aveugle et le fanatisme : il est convaincu d'agir pour le bien de l'humanité.",
            'chapitre_id' => $jojoCh4->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Comparatif des antagonistes principaux',
            'texte'            => "Antagoniste    | Partie | Stand                       | Philosophie\nDio Brando     | 1 & 3  | The World                   | Domination absolue, transcendance\nKars           | 2      | (Être Ultime)               | Perfection biologique\nKira Yoshikage | 4      | Killer Queen                | Paix par l'anonymat et le meurtre\nDiavolo        | 5      | King Crimson                | Secret = pouvoir, paranoïa\nEnrico Pucci   | 6      | Made in Heaven              | Foi + déterminisme\nValentine      | 7      | Dirty Deeds Done Dirt Cheap | Patriotisme extrême",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $jojoSc4_2->id,
        ]);

        $jojoQuiz4 = Quiz::create([
            'titre'            => 'Quiz – Les grands antagonistes',
            'sous_chapitre_id' => $jojoSc4_1->id,
        ]);

        $jojoQuestionsQuiz4 = [
            [
                'texte'    => "Que signifie 'DIO' en italien ?",
                'reponses' => [
                    ['texte' => 'Diable', 'est_correcte' => false],
                    ['texte' => 'Dieu',   'est_correcte' => true],
                    ['texte' => 'Destin', 'est_correcte' => false],
                    ['texte' => 'Mort',   'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Quelle est la motivation principale de Kira Yoshikage ?",
                'reponses' => [
                    ['texte' => 'Conquérir le monde',  'est_correcte' => false],
                    ['texte' => 'Devenir un vampire',  'est_correcte' => false],
                    ['texte' => 'Vivre une vie calme', 'est_correcte' => true],
                    ['texte' => 'Venger son père',     'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Quel Stand utilise Enrico Pucci dans sa forme finale ?",
                'reponses' => [
                    ['texte' => 'King Crimson',   'est_correcte' => false],
                    ['texte' => 'The World',      'est_correcte' => false],
                    ['texte' => 'Made in Heaven', 'est_correcte' => true],
                    ['texte' => 'Killer Queen',   'est_correcte' => false],
                ],
            ],
            [
                'texte'    => "Vrai ou Faux : l'identité de Diavolo est connue de tous ses lieutenants.",
                'reponses' => [
                    ['texte' => 'Vrai', 'est_correcte' => false],
                    ['texte' => 'Faux', 'est_correcte' => true],
                ],
            ],
            [
                'texte'    => "Quelle partie de Jonathan Joestar DIO a-t-il utilisé pour se ressusciter ?",
                'reponses' => [
                    ['texte' => 'La tête',  'est_correcte' => false],
                    ['texte' => 'Le corps', 'est_correcte' => true],
                    ['texte' => 'Le bras',  'est_correcte' => false],
                    ['texte' => 'Le sang',  'est_correcte' => false],
                ],
            ],
        ];

        foreach ($jojoQuestionsQuiz4 as $jojoQData) {
            $jojoQ = Question::create(['texte' => $jojoQData['texte'], 'quiz_id' => $jojoQuiz4->id]);
            foreach ($jojoQData['reponses'] as $jojoR) {
                Reponse::create(['texte' => $jojoR['texte'], 'est_correcte' => $jojoR['est_correcte'], 'question_id' => $jojoQ->id]);
            }
        }

        // ════════════════════════════════════════════════════════════════════
        // FORMATION 3 – Les Capitales européennes
        // ════════════════════════════════════════════════════════════════════
        $capFormation = Formation::create([
            'nom'         => 'Géographie – Les Capitales européennes',
            'description' => 'Apprenez à localiser et mémoriser les capitales des pays d\'Europe, de Lisbonne à Moscou, en passant par les Balkans et les pays baltes.',
            'niveau'      => 'débutant',
            'duree'       => 3,
        ]);

        // ── Chapitre 1 – Europe de l'Ouest ──────────────────────────────────
        $capCh1 = Chapitre::create([
            'titre'        => 'L\'Europe de l\'Ouest',
            'description'  => 'Les capitales des grandes nations d\'Europe occidentale.',
            'formation_id' => $capFormation->id,
            'ordre'        => 1,
        ]);

        $capSc1_1 = SousChapitre::create([
            'titre'       => 'France, Espagne, Portugal et Italie',
            'contenu'     => "## France – Paris\n**Paris** est la capitale et plus grande ville de France, avec plus de 2 millions d'habitants intramuros (12 millions en région parisienne). Fondée par les Parisii gaulois, elle est aujourd'hui un centre mondial de la culture, de la mode et de la diplomatie. Monuments emblématiques : la Tour Eiffel, le Louvre, Notre-Dame de Paris.\n\n## Espagne – Madrid\n**Madrid** est la capitale de l'Espagne depuis 1561, sous Philippe II. Située au centre géographique de la péninsule ibérique (altitude 646 m — ville la plus haute d'UE), elle abrite le Musée du Prado, l'un des plus grands musées du monde.\n\n## Portugal – Lisbonne\n**Lisbonne** (Lisboa) est la capitale du Portugal et la ville la plus à l'ouest de l'Europe continentale. Connue pour ses tramways, ses azulejos et le quartier d'Alfama. Elle fut un centre majeur de l'exploration maritime au XVe siècle.\n\n## Italie – Rome\n**Rome** est la capitale de l'Italie et l'une des plus anciennes villes du monde (fondée en 753 av. J.-C. selon la tradition). Surnommée la « Ville Éternelle », elle concentre une densité inégalée de monuments antiques (Colisée, Forum romain, Panthéon) et abrite l'État du Vatican en son sein.",
            'chapitre_id' => $capCh1->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Fiche mémo – Capitales Sud-Ouest',
            'texte'            => "Pays          | Capitale  | Langue officielle | Population capitale\nFrance        | Paris     | Français          | ~2,1 millions\nEspagne       | Madrid    | Espagnol          | ~3,3 millions\nPortugal      | Lisbonne  | Portugais         | ~0,5 millions\nItalie        | Rome      | Italien           | ~2,8 millions\n\nAstuce mémo : « PMLR » — Paris, Madrid, Lisbonne, Rome. Pensez à la route qui longe la côte atlantique puis méditerranéenne.",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $capSc1_1->id,
        ]);

        $capSc1_2 = SousChapitre::create([
            'titre'       => 'Allemagne, Belgique, Pays-Bas et Autriche',
            'contenu'     => "## Allemagne – Berlin\n**Berlin** est redevenue la capitale unifiée de l'Allemagne en 1990 après la chute du Mur (1989). Avec 3,7 millions d'habitants, c'est la plus grande ville d'Allemagne. Symboles : la Porte de Brandebourg, le Reichstag, le mémorial de l'Holocauste.\n\n## Belgique – Bruxelles\n**Bruxelles** (Brussel) est la capitale de la Belgique et siège de l'Union européenne et de l'OTAN. Ville bilingue (français/néerlandais), elle est réputée pour ses chocolats, ses bières et la Grand-Place, classée UNESCO.\n\n## Pays-Bas – Amsterdam\n**Amsterdam** est la capitale constitutionnelle des Pays-Bas, bien que La Haye soit le siège du gouvernement. Construite sur 90 îles reliées par 1 500 ponts, elle est célèbre pour ses canaux, le musée Van Gogh et Anne Frank.\n\n## Autriche – Vienne\n**Vienne** (Wien) est la capitale de l'Autriche et ancienne capitale de l'Empire austro-hongrois. Berceau de la musique classique (Mozart, Beethoven, Schubert y ont vécu), elle accueille de nombreuses organisations internationales (AIEA, OPEP).",
            'chapitre_id' => $capCh1->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Fiche mémo – Capitales Europe centrale-ouest',
            'texte'            => "Pays       | Capitale   | Langue officielle     | Particularité\nAllemagne  | Berlin     | Allemand              | Réunifiée en 1990\nBelgique   | Bruxelles  | FR / NL / DE          | Siège de l'UE et l'OTAN\nPays-Bas   | Amsterdam  | Néerlandais           | Capitale ≠ siège du gouv.\nAutriche   | Vienne     | Allemand              | Berceau musique classique",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $capSc1_2->id,
        ]);

        $capQuiz1 = Quiz::create([
            'titre'            => 'Quiz – Capitales d\'Europe de l\'Ouest',
            'sous_chapitre_id' => $capSc1_1->id,
        ]);

        $capQuestionsQuiz1 = [
            ['texte' => "Quelle est la capitale de l'Espagne ?",
             'reponses' => [['texte'=>'Barcelone','est_correcte'=>false],['texte'=>'Madrid','est_correcte'=>true],['texte'=>'Séville','est_correcte'=>false],['texte'=>'Valence','est_correcte'=>false]]],
            ['texte' => "Dans quelle ville se trouve le siège de l'Union européenne ?",
             'reponses' => [['texte'=>'Paris','est_correcte'=>false],['texte'=>'Genève','est_correcte'=>false],['texte'=>'Bruxelles','est_correcte'=>true],['texte'=>'Luxembourg','est_correcte'=>false]]],
            ['texte' => "Quelle ville est surnommée la « Ville Éternelle » ?",
             'reponses' => [['texte'=>'Athènes','est_correcte'=>false],['texte'=>'Rome','est_correcte'=>true],['texte'=>'Paris','est_correcte'=>false],['texte'=>'Madrid','est_correcte'=>false]]],
            ['texte' => "Berlin est devenue la capitale unifiée de l'Allemagne après quel événement ?",
             'reponses' => [['texte'=>'La Seconde Guerre mondiale','est_correcte'=>false],['texte'=>'La chute du Mur de Berlin','est_correcte'=>true],['texte'=>'La Réunification économique','est_correcte'=>false],['texte'=>'L\'entrée dans l\'UE','est_correcte'=>false]]],
            ['texte' => "Vrai ou Faux : Amsterdam est à la fois la capitale et le siège du gouvernement des Pays-Bas.",
             'reponses' => [['texte'=>'Vrai','est_correcte'=>false],['texte'=>'Faux','est_correcte'=>true]]],
        ];

        foreach ($capQuestionsQuiz1 as $capQData) {
            $capQ = Question::create(['texte' => $capQData['texte'], 'quiz_id' => $capQuiz1->id]);
            foreach ($capQData['reponses'] as $capR) {
                Reponse::create(['texte' => $capR['texte'], 'est_correcte' => $capR['est_correcte'], 'question_id' => $capQ->id]);
            }
        }

        // ── Chapitre 2 – Europe du Nord ──────────────────────────────────────
        $capCh2 = Chapitre::create([
            'titre'        => 'L\'Europe du Nord et des îles',
            'description'  => 'Scandinavie, îles britanniques et pays baltes.',
            'formation_id' => $capFormation->id,
            'ordre'        => 2,
        ]);

        $capSc2_1 = SousChapitre::create([
            'titre'       => 'Scandinavie et îles britanniques',
            'contenu'     => "## Royaume-Uni – Londres\n**Londres** est la capitale du Royaume-Uni et l'une des métropoles mondiales les plus influentes. Peuplée de ~9 millions d'habitants, elle est un centre financier mondial (City of London), culturel et politique. Monuments : Big Ben, Tower of London, Buckingham Palace.\n\n## Irlande – Dublin\n**Dublin** est la capitale de la République d'Irlande. Ville universitaire (Trinity College, fondé en 1592), elle est connue pour sa culture gaélique, ses pubs et avoir donné naissance à des écrivains comme James Joyce et Samuel Beckett.\n\n## Suède – Stockholm\n**Stockholm** est construite sur 14 îles à la jonction du lac Mälar et de la mer Baltique. Siège du Prix Nobel depuis 1901, c'est aussi la ville natale d'ABBA et de nombreuses startups tech (Spotify, Klarna).\n\n## Norvège – Oslo\n**Oslo** est entourée de forêts et de fjords. Connue pour ses musées vikings et comme ville symbolique de la paix (les Prix Nobel de la Paix y sont remis). Population : ~700 000 habitants.",
            'chapitre_id' => $capCh2->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Fiche mémo – Capitales du Nord',
            'texte'            => "Pays          | Capitale    | Langue         | Anecdote\nRoyaume-Uni   | Londres     | Anglais        | Centre financier mondial\nIrlande       | Dublin      | Anglais / Irlandais | James Joyce, Beckett\nSuède         | Stockholm   | Suédois        | Berceau du Prix Nobel\nNorvège       | Oslo        | Norvégien      | Prix Nobel de la Paix\nDanemark      | Copenhague  | Danois         | La Petite Sirène\nFinlande      | Helsinki    | Finnois / Suédois | La plus proche de Moscou",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $capSc2_1->id,
        ]);

        $capSc2_2 = SousChapitre::create([
            'titre'       => 'Pays baltes et Europe de l\'Est',
            'contenu'     => "## Estonie – Tallinn\n**Tallinn** est remarquable pour son centre médiéval exceptionnel, classé UNESCO. C'est l'un des pays les plus numérisés au monde (e-gouvernement, e-résidence).\n\n## Lettonie – Riga\n**Riga** est la plus grande ville des pays baltes (~600 000 habitants). Son centre historique, avec ses bâtiments Art nouveau, est classé UNESCO.\n\n## Lituanie – Vilnius\n**Vilnius** possède le plus grand centre historique baroque d'Europe de l'Est, également classé UNESCO. La Lituanie est le premier des pays baltes à avoir déclaré son indépendance (1990).\n\n## Pologne – Varsovie\n**Varsovie** (Warszawa) a été reconstruite intégralement après la Seconde Guerre mondiale, où elle fut détruite à 85 %. Cette reconstruction fidèle lui a valu le classement UNESCO. Capitale culturelle et économique de la Pologne.",
            'chapitre_id' => $capCh2->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Fiche mémo – Pays baltes et Pologne',
            'texte'            => "Pays      | Capitale | Langue   | Particularité\nEstonie   | Tallinn  | Estonien | Centre médiéval UNESCO, e-gouvernement\nLettonie  | Riga     | Letton   | Art nouveau, plus grande ville balte\nLituanie  | Vilnius  | Lituanien| Baroque UNESCO, 1ère indépendance 1990\nPologne   | Varsovie | Polonais | Reconstruite après WWII, classée UNESCO",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $capSc2_2->id,
        ]);

        $capQuiz2 = Quiz::create([
            'titre'            => 'Quiz – Capitales du Nord et de l\'Est',
            'sous_chapitre_id' => $capSc2_1->id,
        ]);

        $capQuestionsQuiz2 = [
            ['texte' => "Quelle est la capitale de la Suède ?",
             'reponses' => [['texte'=>'Oslo','est_correcte'=>false],['texte'=>'Copenhague','est_correcte'=>false],['texte'=>'Stockholm','est_correcte'=>true],['texte'=>'Helsinki','est_correcte'=>false]]],
            ['texte' => "Dans quelle ville les Prix Nobel de la Paix sont-ils remis ?",
             'reponses' => [['texte'=>'Stockholm','est_correcte'=>false],['texte'=>'Oslo','est_correcte'=>true],['texte'=>'Genève','est_correcte'=>false],['texte'=>'Bruxelles','est_correcte'=>false]]],
            ['texte' => "Quelle est la capitale de la Lettonie ?",
             'reponses' => [['texte'=>'Tallinn','est_correcte'=>false],['texte'=>'Vilnius','est_correcte'=>false],['texte'=>'Riga','est_correcte'=>true],['texte'=>'Varsovie','est_correcte'=>false]]],
            ['texte' => "Varsovie a été détruite à quel pourcentage lors de la Seconde Guerre mondiale ?",
             'reponses' => [['texte'=>'40 %','est_correcte'=>false],['texte'=>'60 %','est_correcte'=>false],['texte'=>'85 %','est_correcte'=>true],['texte'=>'100 %','est_correcte'=>false]]],
            ['texte' => "Quelle est la capitale de l'Irlande ?",
             'reponses' => [['texte'=>'Cork','est_correcte'=>false],['texte'=>'Belfast','est_correcte'=>false],['texte'=>'Dublin','est_correcte'=>true],['texte'=>'Galway','est_correcte'=>false]]],
        ];

        foreach ($capQuestionsQuiz2 as $capQData) {
            $capQ = Question::create(['texte' => $capQData['texte'], 'quiz_id' => $capQuiz2->id]);
            foreach ($capQData['reponses'] as $capR) {
                Reponse::create(['texte' => $capR['texte'], 'est_correcte' => $capR['est_correcte'], 'question_id' => $capQ->id]);
            }
        }

        // ── Chapitre 3 – Europe du Sud-Est ───────────────────────────────────
        $capCh3 = Chapitre::create([
            'titre'        => 'L\'Europe du Sud-Est et les Balkans',
            'description'  => 'Grèce, Balkans et péninsule balkanique.',
            'formation_id' => $capFormation->id,
            'ordre'        => 3,
        ]);

        $capSc3_1 = SousChapitre::create([
            'titre'       => 'Grèce, Roumanie, Bulgarie et Hongrie',
            'contenu'     => "## Grèce – Athènes\n**Athènes** est l'une des plus anciennes villes du monde (habitée depuis 3 000 ans av. J.-C.). Berceau de la démocratie, de la philosophie et du théâtre occidentaux. L'Acropole et le Parthénon en sont les symboles.\n\n## Roumanie – Bucarest\n**Bucarest** est souvent appelée « le Petit Paris » pour son architecture de la Belle Époque et ses boulevards haussmanniens. Elle abrite le Palais du Parlement, le deuxième plus grand bâtiment administratif du monde.\n\n## Bulgarie – Sofia\n**Sofia** est la capitale la plus élevée de l'UE (550 m d'altitude). La cathédrale Alexandre-Nevski est l'un des plus grands édifices orthodoxes d'Europe.\n\n## Hongrie – Budapest\n**Budapest** est née de la fusion de Buda et Pest en 1873. Le Parlement hongrois sur le Danube est l'un des plus beaux d'Europe. La ville est réputée pour ses bains thermaux (Széchenyi, Gellért).",
            'chapitre_id' => $capCh3->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Fiche mémo – Capitales Sud-Est',
            'texte'            => "Pays      | Capitale  | Langue    | Anecdote\nGrèce     | Athènes   | Grec      | Berceau de la démocratie, Acropole\nRoumanie  | Bucarest  | Roumain   | « Petit Paris », 2e plus grand bâtiment du monde\nBulgarie  | Sofia     | Bulgare   | Capitale UE la plus haute\nHongrie   | Budapest  | Hongrois  | Buda + Pest fusionnés en 1873\nCroatie   | Zagreb    | Croate    | Entrée dans l'UE en 2013\nSlovénie  | Ljubljana | Slovène   | Plus petit pays d'ex-Yougoslavie",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $capSc3_1->id,
        ]);

        $capQuiz3 = Quiz::create([
            'titre'            => 'Quiz – Balkans et Europe du Sud-Est',
            'sous_chapitre_id' => $capSc3_1->id,
        ]);

        $capQuestionsQuiz3 = [
            ['texte' => "Quelle est la capitale de la Grèce ?",
             'reponses' => [['texte'=>'Thessalonique','est_correcte'=>false],['texte'=>'Athènes','est_correcte'=>true],['texte'=>'Héraklion','est_correcte'=>false],['texte'=>'Patras','est_correcte'=>false]]],
            ['texte' => "Quel surnom donne-t-on à Bucarest ?",
             'reponses' => [['texte'=>'La Ville Éternelle','est_correcte'=>false],['texte'=>'Le Petit Paris','est_correcte'=>true],['texte'=>'La Perle du Danube','est_correcte'=>false],['texte'=>'La Belle du Sud','est_correcte'=>false]]],
            ['texte' => "Budapest est née de la fusion de deux villes. Lesquelles ?",
             'reponses' => [['texte'=>'Buda et Dalmate','est_correcte'=>false],['texte'=>'Buda et Pest','est_correcte'=>true],['texte'=>'Bude et Pesta','est_correcte'=>false],['texte'=>'Buda et Brest','est_correcte'=>false]]],
            ['texte' => "Quelle est la capitale la plus élevée de l'Union européenne ?",
             'reponses' => [['texte'=>'Madrid','est_correcte'=>false],['texte'=>'Andorre-la-Vieille','est_correcte'=>false],['texte'=>'Sofia','est_correcte'=>true],['texte'=>'Berne','est_correcte'=>false]]],
            ['texte' => "Quelle est la capitale de la Hongrie ?",
             'reponses' => [['texte'=>'Varsovie','est_correcte'=>false],['texte'=>'Prague','est_correcte'=>false],['texte'=>'Vienne','est_correcte'=>false],['texte'=>'Budapest','est_correcte'=>true]]],
        ];

        foreach ($capQuestionsQuiz3 as $capQData) {
            $capQ = Question::create(['texte' => $capQData['texte'], 'quiz_id' => $capQuiz3->id]);
            foreach ($capQData['reponses'] as $capR) {
                Reponse::create(['texte' => $capR['texte'], 'est_correcte' => $capR['est_correcte'], 'question_id' => $capQ->id]);
            }
        }

        // ════════════════════════════════════════════════════════════════════
        // FORMATION 4 – Introduction à Python
        // ════════════════════════════════════════════════════════════════════
        $pyFormation = Formation::create([
            'nom'         => 'Introduction à Python – Les bases du langage',
            'description' => 'Maîtrisez les fondamentaux de Python, le langage de programmation le plus populaire au monde. Variables, conditions, boucles, fonctions : tout ce qu\'il faut pour coder avec confiance.',
            'niveau'      => 'débutant',
            'duree'       => 5,
        ]);

        // ── Chapitre 1 – Variables et types ─────────────────────────────────
        $pyCh1 = Chapitre::create([
            'titre'        => 'Variables et types de données',
            'description'  => 'Comprendre comment Python stocke et manipule l\'information.',
            'formation_id' => $pyFormation->id,
            'ordre'        => 1,
        ]);

        $pySc1_1 = SousChapitre::create([
            'titre'       => 'Les variables et l\'assignation',
            'contenu'     => "En Python, une **variable** est un nom qui pointe vers une valeur stockée en mémoire. Pas besoin de déclarer le type : Python le détecte automatiquement.\n\n```python\nnom = \"Alice\"       # str (chaîne de caractères)\nage = 25            # int (entier)\ntaille = 1.68       # float (décimal)\nest_etudiant = True # bool (booléen)\n```\n\n**Règles de nommage :**\n- Commence par une lettre ou _ (pas un chiffre)\n- Pas d'espaces (utiliser_underscore)\n- Sensible à la casse : `Age` ≠ `age`\n- Éviter les mots réservés : `if`, `for`, `while`, `class`…\n\n**La fonction `type()` :**\nPour connaître le type d'une variable :\n```python\nprint(type(age))    # <class 'int'>\nprint(type(nom))    # <class 'str'>\n```\n\n**Affichage avec `print()` :**\n```python\nprint(\"Bonjour\", nom)         # Bonjour Alice\nprint(f\"J'ai {age} ans\")     # J'ai 25 ans  (f-string)\n```",
            'chapitre_id' => $pyCh1->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Les 4 types de base en Python',
            'texte'            => "Type  | Exemple        | Description\nint   | 42, -7, 0      | Nombre entier\nfloat | 3.14, -0.5     | Nombre à virgule\nstr   | \"bonjour\", 'ok' | Chaîne de texte\nbool  | True, False    | Valeur logique\n\nConversions :\n• int(\"42\") → 42\n• float(3) → 3.0\n• str(100) → \"100\"\n• bool(0) → False, bool(1) → True\n\nAttention : en Python, True vaut 1 et False vaut 0.",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $pySc1_1->id,
        ]);

        $pySc1_2 = SousChapitre::create([
            'titre'       => 'Les opérateurs',
            'contenu'     => "Python dispose de plusieurs catégories d'opérateurs.\n\n**Opérateurs arithmétiques :**\n```python\n5 + 3   # 8  (addition)\n10 - 4  # 6  (soustraction)\n3 * 4   # 12 (multiplication)\n10 / 3  # 3.333... (division réelle)\n10 // 3 # 3  (division entière)\n10 % 3  # 1  (modulo = reste)\n2 ** 8  # 256 (puissance)\n```\n\n**Opérateurs de comparaison** (retournent True/False) :\n```python\n5 == 5   # True  (égalité)\n5 != 3   # True  (différent)\n5 > 3    # True  (supérieur)\n5 < 3    # False (inférieur)\n5 >= 5   # True  (supérieur ou égal)\n```\n\n**Opérateurs logiques :**\n```python\nTrue and False  # False\nTrue or False   # True\nnot True        # False\n```\n\n**Opérateurs d'assignation :**\n```python\nx = 10\nx += 3  # x vaut maintenant 13\nx *= 2  # x vaut maintenant 26\n```",
            'chapitre_id' => $pyCh1->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Tableau des opérateurs Python',
            'texte'            => "Catégorie      | Opérateurs\nArithmétiques  | + - * / // % **\nComparaison    | == != > < >= <=\nLogiques       | and or not\nAssignation    | = += -= *= /= //= **=\n\nPriorité (de haute à basse) :\n1. ** (puissance)\n2. * / // %\n3. + -\n4. == != > < >= <=\n5. not\n6. and\n7. or\n\nUtilisez des parenthèses pour forcer l'ordre voulu.",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $pySc1_2->id,
        ]);

        $pyQuiz1 = Quiz::create([
            'titre'            => 'Quiz – Variables et types Python',
            'sous_chapitre_id' => $pySc1_1->id,
        ]);

        $pyQuestionsQuiz1 = [
            ['texte' => "Quel est le type de la valeur : 3.14 ?",
             'reponses' => [['texte'=>'int','est_correcte'=>false],['texte'=>'str','est_correcte'=>false],['texte'=>'float','est_correcte'=>true],['texte'=>'bool','est_correcte'=>false]]],
            ['texte' => "Quelle est la valeur de : 10 % 3 ?",
             'reponses' => [['texte'=>'3','est_correcte'=>false],['texte'=>'1','est_correcte'=>true],['texte'=>'0','est_correcte'=>false],['texte'=>'30','est_correcte'=>false]]],
            ['texte' => "Que retourne : bool(0) en Python ?",
             'reponses' => [['texte'=>'True','est_correcte'=>false],['texte'=>'0','est_correcte'=>false],['texte'=>'False','est_correcte'=>true],['texte'=>'None','est_correcte'=>false]]],
            ['texte' => "Quelle syntaxe est correcte pour afficher une variable avec une f-string ?",
             'reponses' => [['texte'=>'print(\"Age : \" + age)','est_correcte'=>false],['texte'=>'print(f\"Age : {age}\")','est_correcte'=>true],['texte'=>'print(\"Age : {age}\")','est_correcte'=>false],['texte'=>'echo age','est_correcte'=>false]]],
            ['texte' => "Vrai ou Faux : en Python, les noms de variables sont sensibles à la casse.",
             'reponses' => [['texte'=>'Vrai','est_correcte'=>true],['texte'=>'Faux','est_correcte'=>false]]],
        ];

        foreach ($pyQuestionsQuiz1 as $pyQData) {
            $pyQ = Question::create(['texte' => $pyQData['texte'], 'quiz_id' => $pyQuiz1->id]);
            foreach ($pyQData['reponses'] as $pyR) {
                Reponse::create(['texte' => $pyR['texte'], 'est_correcte' => $pyR['est_correcte'], 'question_id' => $pyQ->id]);
            }
        }

        // ── Chapitre 2 – Structures de contrôle ─────────────────────────────
        $pyCh2 = Chapitre::create([
            'titre'        => 'Structures de contrôle',
            'description'  => 'Conditions et boucles : rendre vos programmes intelligents et répétitifs.',
            'formation_id' => $pyFormation->id,
            'ordre'        => 2,
        ]);

        $pySc2_1 = SousChapitre::create([
            'titre'       => 'Les conditions : if / elif / else',
            'contenu'     => "Les conditions permettent d'exécuter du code **selon une situation**.\n\n**Syntaxe de base :**\n```python\nage = 18\n\nif age >= 18:\n    print(\"Vous êtes majeur.\")\nelse:\n    print(\"Vous êtes mineur.\")\n```\n\n**Avec elif (sinon si) :**\n```python\nnote = 75\n\nif note >= 90:\n    print(\"Excellent\")\nelif note >= 70:\n    print(\"Bien\")\nelif note >= 50:\n    print(\"Passable\")\nelse:\n    print(\"Insuffisant\")\n```\n\n**Points importants :**\n- L'**indentation** (4 espaces) est obligatoire en Python — c'est elle qui délimite les blocs.\n- Pas de `{}` comme en PHP ou JavaScript.\n- Les deux-points `:` à la fin de chaque condition sont obligatoires.\n\n**Condition ternaire (sur une ligne) :**\n```python\nstatus = \"majeur\" if age >= 18 else \"mineur\"\n```",
            'chapitre_id' => $pyCh2->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Structure complète if / elif / else',
            'texte'            => "Forme complète :\nif condition1:\n    # bloc 1\nelif condition2:\n    # bloc 2\nelif condition3:\n    # bloc 3\nelse:\n    # bloc par défaut\n\nRègles :\n• Un seul if (obligatoire)\n• Autant de elif que nécessaire (optionnel)\n• Un seul else (optionnel, toujours en dernier)\n• L'indentation (4 espaces) est OBLIGATOIRE\n\nErreurs fréquentes :\n✗ if x = 5  → erreur (utiliser ==)\n✓ if x == 5\n✗ if(x > 0)  → valide mais déconseillé\n✓ if x > 0",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $pySc2_1->id,
        ]);

        $pySc2_2 = SousChapitre::create([
            'titre'       => 'Les boucles : for et while',
            'contenu'     => "Les boucles répètent un bloc de code.\n\n## La boucle `for`\nUtilisée quand on connaît le nombre d'itérations à l'avance :\n```python\n# Parcourir une liste\nfruits = [\"pomme\", \"banane\", \"cerise\"]\nfor fruit in fruits:\n    print(fruit)\n\n# Parcourir un intervalle\nfor i in range(5):       # 0, 1, 2, 3, 4\n    print(i)\n\nfor i in range(1, 6):    # 1, 2, 3, 4, 5\n    print(i)\n```\n\n## La boucle `while`\nTourne tant qu'une condition est vraie :\n```python\ncompteur = 0\nwhile compteur < 5:\n    print(compteur)\n    compteur += 1   # IMPORTANT : toujours modifier la condition !\n```\n\n## `break` et `continue`\n```python\nfor i in range(10):\n    if i == 5:\n        break       # Arrête la boucle\n    if i % 2 == 0:\n        continue    # Passe à l'itération suivante\n    print(i)        # Affiche : 1, 3\n```",
            'chapitre_id' => $pyCh2->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'for vs while – Quand utiliser lequel ?',
            'texte'            => "Utilisez FOR quand :\n• Vous connaissez le nombre d'itérations\n• Vous parcourez une liste, un tuple, une chaîne\n• Vous utilisez range()\n\nUtilisez WHILE quand :\n• La condition de sortie dépend d'un événement extérieur\n• Vous attendez une saisie utilisateur valide\n• Nombre d'itérations inconnu à l'avance\n\nFonctions utiles :\n• range(n)        → 0 à n-1\n• range(a, b)     → a à b-1\n• range(a, b, c)  → a à b-1, par pas de c\n• enumerate(liste)→ donne (index, valeur)\n• len(liste)      → longueur de la liste",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $pySc2_2->id,
        ]);

        $pyQuiz2 = Quiz::create([
            'titre'            => 'Quiz – Conditions et boucles',
            'sous_chapitre_id' => $pySc2_1->id,
        ]);

        $pyQuestionsQuiz2 = [
            ['texte' => "Qu'est-ce qui délimite les blocs de code en Python ?",
             'reponses' => [['texte'=>'Les accolades {}','est_correcte'=>false],['texte'=>'Les parenthèses ()','est_correcte'=>false],['texte'=>'L\'indentation (espaces)','est_correcte'=>true],['texte'=>'Les crochets []','est_correcte'=>false]]],
            ['texte' => "Que produit range(1, 5) ?",
             'reponses' => [['texte'=>'1, 2, 3, 4, 5','est_correcte'=>false],['texte'=>'1, 2, 3, 4','est_correcte'=>true],['texte'=>'0, 1, 2, 3, 4','est_correcte'=>false],['texte'=>'1, 5','est_correcte'=>false]]],
            ['texte' => "Quel mot-clé arrête immédiatement une boucle ?",
             'reponses' => [['texte'=>'stop','est_correcte'=>false],['texte'=>'exit','est_correcte'=>false],['texte'=>'continue','est_correcte'=>false],['texte'=>'break','est_correcte'=>true]]],
            ['texte' => "Combien de blocs `else` peut-on avoir dans un if / elif / else ?",
             'reponses' => [['texte'=>'Autant que l\'on veut','est_correcte'=>false],['texte'=>'Zéro ou un seul','est_correcte'=>true],['texte'=>'Exactement un','est_correcte'=>false],['texte'=>'Deux maximum','est_correcte'=>false]]],
            ['texte' => "Vrai ou Faux : une boucle while peut provoquer une boucle infinie si la condition ne change jamais.",
             'reponses' => [['texte'=>'Vrai','est_correcte'=>true],['texte'=>'Faux','est_correcte'=>false]]],
        ];

        foreach ($pyQuestionsQuiz2 as $pyQData) {
            $pyQ = Question::create(['texte' => $pyQData['texte'], 'quiz_id' => $pyQuiz2->id]);
            foreach ($pyQData['reponses'] as $pyR) {
                Reponse::create(['texte' => $pyR['texte'], 'est_correcte' => $pyR['est_correcte'], 'question_id' => $pyQ->id]);
            }
        }

        // ── Chapitre 3 – Fonctions ───────────────────────────────────────────
        $pyCh3 = Chapitre::create([
            'titre'        => 'Fonctions et modules',
            'description'  => 'Organiser et réutiliser son code grâce aux fonctions et aux modules Python.',
            'formation_id' => $pyFormation->id,
            'ordre'        => 3,
        ]);

        $pySc3_1 = SousChapitre::create([
            'titre'       => 'Définir et appeler une fonction',
            'contenu'     => "Une **fonction** est un bloc de code réutilisable, défini une fois et appelable autant de fois que nécessaire.\n\n**Syntaxe :**\n```python\ndef nom_fonction(parametre1, parametre2):\n    \"\"\"Docstring : description de la fonction\"\"\"\n    # corps de la fonction\n    return resultat\n```\n\n**Exemple simple :**\n```python\ndef saluer(prenom):\n    return f\"Bonjour, {prenom} !\"\n\nmessage = saluer(\"Alice\")\nprint(message)  # Bonjour, Alice !\n```\n\n**Paramètres par défaut :**\n```python\ndef saluer(prenom, langue=\"fr\"):\n    if langue == \"fr\":\n        return f\"Bonjour, {prenom} !\"\n    else:\n        return f\"Hello, {prenom}!\"\n\nprint(saluer(\"Bob\"))          # Bonjour, Bob !\nprint(saluer(\"Bob\", \"en\"))   # Hello, Bob!\n```\n\n**Fonction sans retour (`None`) :**\n```python\ndef afficher_double(n):\n    print(n * 2)   # pas de return → renvoie None\n```",
            'chapitre_id' => $pyCh3->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Bonnes pratiques pour les fonctions',
            'texte'            => "Règles d'or :\n1. Une fonction = une tâche unique (principe de responsabilité unique)\n2. Nommez-la avec un verbe : calculer_moyenne(), afficher_menu()\n3. Ajoutez toujours une docstring pour expliquer ce qu'elle fait\n4. Gardez-la courte (moins de 20 lignes idéalement)\n\nTypes de paramètres :\n• Positionnels : def f(a, b) → appelé f(1, 2)\n• Nommés : def f(a, b=0) → appelé f(a=1) ou f(1)\n• *args : nombre variable d'arguments positionnels\n• **kwargs : nombre variable d'arguments nommés\n\nExemple *args :\ndef somme(*nombres):\n    return sum(nombres)\nprint(somme(1, 2, 3, 4))  # 10",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $pySc3_1->id,
        ]);

        $pySc3_2 = SousChapitre::create([
            'titre'       => 'Les modules et la bibliothèque standard',
            'contenu'     => "Un **module** est un fichier Python contenant des fonctions et variables réutilisables. Python est livré avec une vaste **bibliothèque standard**.\n\n**Importer un module :**\n```python\nimport math\nprint(math.sqrt(16))   # 4.0\nprint(math.pi)         # 3.14159...\n\nimport random\nprint(random.randint(1, 6))  # dé aléatoire\n\nfrom datetime import datetime\nprint(datetime.now())  # date et heure actuelles\n```\n\n**Modules essentiels à connaître :**\n\n| Module   | Utilité principale |\n|----------|-------------------|\n| `math`   | Fonctions mathématiques (sqrt, pi, cos…) |\n| `random` | Génération aléatoire |\n| `os`     | Interaction avec le système d'exploitation |\n| `sys`    | Accès aux paramètres Python |\n| `datetime`| Manipulation des dates |\n| `json`   | Lecture/écriture JSON |\n| `re`     | Expressions régulières |\n\n**Créer son propre module :**\nEnregistrer un fichier `mon_module.py` et l'importer :\n```python\nimport mon_module\nmon_module.ma_fonction()\n```",
            'chapitre_id' => $pyCh3->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Top 5 modules Python indispensables',
            'texte'            => "1. math\n   math.sqrt(x), math.floor(x), math.ceil(x), math.pi\n\n2. random\n   random.randint(a, b)  → entier entre a et b\n   random.choice(liste) → élément aléatoire\n   random.shuffle(liste) → mélange en place\n\n3. os\n   os.getcwd()          → répertoire courant\n   os.listdir(chemin)   → liste fichiers\n   os.path.exists(f)    → vérifie si un fichier existe\n\n4. datetime\n   datetime.now()       → date + heure actuelles\n   datetime.strftime()  → formatage de date\n\n5. json\n   json.loads(chaine)   → JSON → dict Python\n   json.dumps(dict)     → dict Python → JSON",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $pySc3_2->id,
        ]);

        $pyQuiz3 = Quiz::create([
            'titre'            => 'Quiz – Fonctions et modules',
            'sous_chapitre_id' => $pySc3_1->id,
        ]);

        $pyQuestionsQuiz3 = [
            ['texte' => "Quel mot-clé sert à définir une fonction en Python ?",
             'reponses' => [['texte'=>'function','est_correcte'=>false],['texte'=>'func','est_correcte'=>false],['texte'=>'def','est_correcte'=>true],['texte'=>'fn','est_correcte'=>false]]],
            ['texte' => "Que renvoie une fonction sans instruction `return` ?",
             'reponses' => [['texte'=>'0','est_correcte'=>false],['texte'=>'False','est_correcte'=>false],['texte'=>'None','est_correcte'=>true],['texte'=>'Une erreur','est_correcte'=>false]]],
            ['texte' => "Quel module Python permet de générer un nombre aléatoire ?",
             'reponses' => [['texte'=>'math','est_correcte'=>false],['texte'=>'random','est_correcte'=>true],['texte'=>'os','est_correcte'=>false],['texte'=>'sys','est_correcte'=>false]]],
            ['texte' => "Comment calculer la racine carrée de 25 avec le module math ?",
             'reponses' => [['texte'=>'math.square(25)','est_correcte'=>false],['texte'=>'math.sqrt(25)','est_correcte'=>true],['texte'=>'math.racine(25)','est_correcte'=>false],['texte'=>'sqrt(25)','est_correcte'=>false]]],
            ['texte' => "Vrai ou Faux : on peut donner une valeur par défaut à un paramètre de fonction.",
             'reponses' => [['texte'=>'Vrai','est_correcte'=>true],['texte'=>'Faux','est_correcte'=>false]]],
        ];

        foreach ($pyQuestionsQuiz3 as $pyQData) {
            $pyQ = Question::create(['texte' => $pyQData['texte'], 'quiz_id' => $pyQuiz3->id]);
            foreach ($pyQData['reponses'] as $pyR) {
                Reponse::create(['texte' => $pyR['texte'], 'est_correcte' => $pyR['est_correcte'], 'question_id' => $pyQ->id]);
            }
        }

        // ════════════════════════════════════════════════════════════════════
        // FORMATION 5 – La Révolution française
        // ════════════════════════════════════════════════════════════════════
        $revFormation = Formation::create([
            'nom'         => 'Histoire – La Révolution française (1789–1799)',
            'description' => 'Comprenez les causes, les grandes étapes et l\'héritage de la Révolution française, l\'événement qui a redessiné l\'Europe et le monde moderne.',
            'niveau'      => 'intermédiaire',
            'duree'       => 4,
        ]);

        // ── Chapitre 1 – Causes et contexte ─────────────────────────────────
        $revCh1 = Chapitre::create([
            'titre'        => 'Les causes et le contexte',
            'description'  => 'Pourquoi la Révolution a-t-elle éclaté ? Crise économique, inégalités sociales et idées des Lumières.',
            'formation_id' => $revFormation->id,
            'ordre'        => 1,
        ]);

        $revSc1_1 = SousChapitre::create([
            'titre'       => 'La crise de l\'Ancien Régime',
            'contenu'     => "À la veille de 1789, la France est au bord de la faillite et profondément inégalitaire.\n\n## La société des trois ordres\nLa société française était divisée en **trois ordres** :\n- **Le Clergé (1er ordre)** : exempts d'impôts, riches en terres\n- **La Noblesse (2e ordre)** : privilèges fiscaux, monopole des hautes fonctions\n- **Le Tiers État (3e ordre)** : 97 % de la population, supporte l'essentiel des impôts\n\n## La crise financière\nLouis XVI hérite d'une dette colossale aggravée par :\n- Les guerres (dont le soutien à l'indépendance américaine)\n- Les dépenses de la cour de Versailles\n- Les mauvaises récoltes de 1788 (famine)\n\nLe déficit atteint **126 millions de livres** en 1788. Pour renflouer les caisses, Louis XVI convoque les **États généraux** le 5 mai 1789 — une institution non réunie depuis 1614.\n\n## La crise politique\nLouis XVI, roi absolu mais indécis, est incapable de réformer un système bloqué par les privilèges. Sa cote de popularité s'effondre.",
            'chapitre_id' => $revCh1->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Les 3 ordres de l\'Ancien Régime',
            'texte'            => "Ordre       | Qui ?              | % population | Impôts\n1er – Clergé | Évêques, curés     | ~0,5 %       | Exemptés\n2e – Noblesse| Aristocrates       | ~1,5 %       | Exemptés\n3e – Tiers État| Bourgeois, paysans, artisans | ~98 % | Tout supportent\n\nParadoxe central : ceux qui payaient tout n'avaient aucun pouvoir.\nLe vote aux États généraux se faisait par ordre (1 voix chacun) → le Tiers État toujours mis en minorité.\n\nRéforme réclamée : vote par tête (non par ordre) → refusée par Louis XVI → déclencheur direct de la crise.",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $revSc1_1->id,
        ]);

        $revSc1_2 = SousChapitre::create([
            'titre'       => 'Les idées des Lumières',
            'contenu'     => "Le XVIIIe siècle est le siècle des **Lumières** (*Aufklärung*) — un mouvement intellectuel qui remet en cause l'autorité traditionnelle (religion, monarchie absolue) au nom de la **raison**.\n\n## Les philosophes clés\n\n**John Locke (1632–1704)** — Anglais\nThéorie du contrat social : le gouvernement tire sa légitimité du consentement des gouvernés. Droit naturel : vie, liberté, propriété.\n\n**Montesquieu (1689–1755)** — Français\nDans *De l'esprit des lois* (1748), il défend la **séparation des pouvoirs** (exécutif, législatif, judiciaire) comme garantie contre la tyrannie.\n\n**Voltaire (1694–1778)** — Français\nCritique de l'Église, défenseur de la tolérance religieuse et de la liberté d'expression. Affaire Calas (1762).\n\n**Jean-Jacques Rousseau (1712–1778)** — Genevois\nDans *Du Contrat social* (1762) : « La souveraineté appartient au peuple. » Concept de la **volonté générale**.\n\n**L'Encyclopédie** (1751–1772)\nDiderot et d'Alembert dirigent une encyclopédie de 28 volumes qui diffuse les idées nouvelles dans toute l'Europe éduquée.",
            'chapitre_id' => $revCh1->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Tableau des philosophes des Lumières',
            'texte'            => "Philosophe   | Dates     | Idée centrale               | Œuvre clé\nLocke        | 1632–1704 | Contrat social, droits naturels | Deux traités du gouvernement\nMontesquieu  | 1689–1755 | Séparation des pouvoirs     | De l'esprit des lois (1748)\nVoltaire     | 1694–1778 | Tolérance, liberté, raison  | Candide (1759)\nRousseau     | 1712–1778 | Souveraineté populaire      | Du Contrat social (1762)\nDiderot      | 1713–1784 | Diffusion des savoirs       | L'Encyclopédie (1751–72)\n\nLien avec la Révolution :\nCes idées formaient le « logiciel intellectuel » des révolutionnaires. La DDHC de 1789 en est la traduction juridique directe.",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $revSc1_2->id,
        ]);

        $revQuiz1 = Quiz::create([
            'titre'            => 'Quiz – Causes et Ancien Régime',
            'sous_chapitre_id' => $revSc1_1->id,
        ]);

        $revQuestionsQuiz1 = [
            ['texte' => "Combien de temps les États généraux n'avaient-ils pas été réunis avant 1789 ?",
             'reponses' => [['texte'=>'50 ans','est_correcte'=>false],['texte'=>'100 ans','est_correcte'=>false],['texte'=>'175 ans','est_correcte'=>true],['texte'=>'200 ans','est_correcte'=>false]]],
            ['texte' => "Quel philosophe a théorisé la séparation des pouvoirs ?",
             'reponses' => [['texte'=>'Voltaire','est_correcte'=>false],['texte'=>'Rousseau','est_correcte'=>false],['texte'=>'Montesquieu','est_correcte'=>true],['texte'=>'Diderot','est_correcte'=>false]]],
            ['texte' => "Quel pourcentage de la population française représentait le Tiers État ?",
             'reponses' => [['texte'=>'50 %','est_correcte'=>false],['texte'=>'75 %','est_correcte'=>false],['texte'=>'98 %','est_correcte'=>true],['texte'=>'60 %','est_correcte'=>false]]],
            ['texte' => "Quelle œuvre de Rousseau affirme que la souveraineté appartient au peuple ?",
             'reponses' => [['texte'=>'Candide','est_correcte'=>false],['texte'=>'Du Contrat social','est_correcte'=>true],['texte'=>'De l\'esprit des lois','est_correcte'=>false],['texte'=>'L\'Encyclopédie','est_correcte'=>false]]],
            ['texte' => "Vrai ou Faux : le Clergé et la Noblesse payaient les mêmes impôts que le Tiers État.",
             'reponses' => [['texte'=>'Vrai','est_correcte'=>false],['texte'=>'Faux','est_correcte'=>true]]],
        ];

        foreach ($revQuestionsQuiz1 as $revQData) {
            $revQ = Question::create(['texte' => $revQData['texte'], 'quiz_id' => $revQuiz1->id]);
            foreach ($revQData['reponses'] as $revR) {
                Reponse::create(['texte' => $revR['texte'], 'est_correcte' => $revR['est_correcte'], 'question_id' => $revQ->id]);
            }
        }

        // ── Chapitre 2 – Les grandes étapes ─────────────────────────────────
        $revCh2 = Chapitre::create([
            'titre'        => 'Les grandes étapes (1789–1799)',
            'description'  => 'De la prise de la Bastille à l\'avènement de Napoléon.',
            'formation_id' => $revFormation->id,
            'ordre'        => 2,
        ]);

        $revSc2_1 = SousChapitre::create([
            'titre'       => '1789 – L\'année charnière',
            'contenu'     => "## 5 mai 1789 – Ouverture des États généraux\nLouis XVI réunit les États généraux à Versailles pour résoudre la crise financière. Le Tiers État réclame le vote par tête — refus du roi.\n\n## 17 juin 1789 – L'Assemblée nationale\nLe Tiers État, rejoints par des membres du clergé, se proclame **Assemblée nationale** et jure de ne pas se séparer avant d'avoir donné une Constitution à la France (**Serment du Jeu de Paume, 20 juin**).\n\n## 14 juillet 1789 – Prise de la Bastille\nLe peuple parisien prend d'assaut la forteresse de la Bastille, symbole du pouvoir royal arbitraire. C'est le début de la Révolution populaire. Fête nationale française depuis 1880.\n\n## Nuit du 4 août 1789\nL'Assemblée abolit les **privilèges féodaux** — fin de l'Ancien Régime juridique.\n\n## 26 août 1789 – Déclaration des droits de l'homme et du citoyen (DDHC)\n17 articles fondamentaux : liberté, égalité, souveraineté nationale, présomption d'innocence…\n\n## Octobre 1789 – Marche des femmes sur Versailles\nLes femmes parisiennes, affamées, marchent sur Versailles et ramènent la famille royale à Paris.",
            'chapitre_id' => $revCh2->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Chronologie 1789',
            'texte'            => "Date              | Événement\n5 mai 1789        | Ouverture des États généraux à Versailles\n17 juin 1789      | Proclamation de l'Assemblée nationale\n20 juin 1789      | Serment du Jeu de Paume\n14 juillet 1789   | Prise de la Bastille ★\n4 août 1789       | Abolition des privilèges féodaux\n26 août 1789      | Adoption de la DDHC\nOctobre 1789      | Marche des femmes sur Versailles\n\nMémo : La Bastille tombe le 14 juillet → Fête nationale française.",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $revSc2_1->id,
        ]);

        $revSc2_2 = SousChapitre::create([
            'titre'       => 'La Terreur, la République et le Directoire (1792–1799)',
            'contenu'     => "## 1792 – Proclamation de la Première République\nAprès la fuite de Louis XVI (juin 1791) et son arrestation, la monarchie est abolie le **21 septembre 1792**. La France devient une République.\n\n## 21 janvier 1793 – Exécution de Louis XVI\nLouis XVI est guillotiné sur la place de la Révolution (actuelle place de la Concorde). Marie-Antoinette sera exécutée le 16 octobre 1793.\n\n## 1793–1794 – La Terreur\nSous la direction de **Robespierre** et du Comité de salut public, la France connaît la **Terreur** : plus de **17 000 condamnations à mort** officielles, des dizaines de milliers de victimes au total. Objectif affiché : défendre la Révolution contre ses ennemis intérieurs.\n\n## Juillet 1794 – Thermidor\nRobespierre est renversé et guillotiné le **9 thermidor an II** (27 juillet 1794). Fin de la Terreur.\n\n## 1795–1799 – Le Directoire\nRégime instable de cinq directeurs. Corruption, crises économiques et militaires affaiblissent le gouvernement.\n\n## 9 novembre 1799 – Coup d'État de Bonaparte\n**Napoléon Bonaparte**, fort de ses victoires militaires, renverse le Directoire (**18 brumaire an VIII**) et instaure le Consulat. La Révolution prend fin.",
            'chapitre_id' => $revCh2->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Les régimes successifs de la Révolution',
            'texte'            => "Période         | Régime                  | Dates\n1789–1792       | Monarchie constitutionnelle | 1789–1792\n1792–1795       | Convention nationale    | 1792–1795\n1793–1794       | La Terreur (dans la Convention) | 1793–94\n1795–1799       | Directoire              | 1795–1799\n1799–1804       | Consulat (Bonaparte)    | 1799–1804\n\nPersonnages clés :\n• Robespierre – « L'Incorruptible », artisan de la Terreur\n• Danton – Figure populaire, guillotiné par Robespierre\n• Marat – Journaliste révolutionnaire, assassiné dans son bain\n• Napoleon Bonaparte – Général, puis Premier Consul",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $revSc2_2->id,
        ]);

        $revQuiz2 = Quiz::create([
            'titre'            => 'Quiz – Les étapes de la Révolution',
            'sous_chapitre_id' => $revSc2_1->id,
        ]);

        $revQuestionsQuiz2 = [
            ['texte' => "Quelle date est devenue la fête nationale française ?",
             'reponses' => [['texte'=>'26 août','est_correcte'=>false],['texte'=>'5 mai','est_correcte'=>false],['texte'=>'14 juillet','est_correcte'=>true],['texte'=>'21 septembre','est_correcte'=>false]]],
            ['texte' => "Qui dirige le Comité de salut public pendant la Terreur ?",
             'reponses' => [['texte'=>'Napoléon','est_correcte'=>false],['texte'=>'Louis XVI','est_correcte'=>false],['texte'=>'Robespierre','est_correcte'=>true],['texte'=>'Danton','est_correcte'=>false]]],
            ['texte' => "Combien de condamnations à mort officielles pendant la Terreur ?",
             'reponses' => [['texte'=>'5 000','est_correcte'=>false],['texte'=>'17 000','est_correcte'=>true],['texte'=>'50 000','est_correcte'=>false],['texte'=>'1 000','est_correcte'=>false]]],
            ['texte' => "Quel événement met fin à la Révolution française ?",
             'reponses' => [['texte'=>'L\'exécution de Louis XVI','est_correcte'=>false],['texte'=>'La chute de Robespierre','est_correcte'=>false],['texte'=>'Le coup d\'État de Bonaparte (18 brumaire)','est_correcte'=>true],['texte'=>'La prise de la Bastille','est_correcte'=>false]]],
            ['texte' => "Vrai ou Faux : Marie-Antoinette a été exécutée le même jour que Louis XVI.",
             'reponses' => [['texte'=>'Vrai','est_correcte'=>false],['texte'=>'Faux','est_correcte'=>true]]],
        ];

        foreach ($revQuestionsQuiz2 as $revQData) {
            $revQ = Question::create(['texte' => $revQData['texte'], 'quiz_id' => $revQuiz2->id]);
            foreach ($revQData['reponses'] as $revR) {
                Reponse::create(['texte' => $revR['texte'], 'est_correcte' => $revR['est_correcte'], 'question_id' => $revQ->id]);
            }
        }

        // ── Chapitre 3 – Héritage ────────────────────────────────────────────
        $revCh3 = Chapitre::create([
            'titre'        => 'Héritage et influence dans le monde',
            'description'  => 'La Révolution française a changé le monde. Découvrez comment ses idées ont traversé les siècles.',
            'formation_id' => $revFormation->id,
            'ordre'        => 3,
        ]);

        $revSc3_1 = SousChapitre::create([
            'titre'       => 'La Déclaration des droits de l\'homme et du citoyen',
            'contenu'     => "Adoptée le **26 août 1789**, la DDHC est l'un des textes fondateurs des droits modernes.\n\n## Les 17 articles – Principaux principes\n\n**Article 1** : « Les hommes naissent et demeurent libres et égaux en droits. »\n\n**Article 2** : Les droits naturels et imprescriptibles sont la **liberté, la propriété, la sûreté et la résistance à l'oppression**.\n\n**Article 3** : Le principe de toute souveraineté réside dans la **nation**.\n\n**Article 6** : La loi est l'expression de la volonté générale. Tous les citoyens ont le droit de participer à sa formation.\n\n**Article 9** : Tout homme est présumé innocent jusqu'à ce qu'il ait été déclaré coupable (**présomption d'innocence**).\n\n**Article 11** : La libre communication des pensées et des opinions est l'un des droits les plus précieux de l'homme (**liberté d'expression**).\n\n## Limites historiques\n- La DDHC s'appliquait aux hommes (et non aux femmes). Olympe de Gouges rédige la *Déclaration des droits de la femme et de la citoyenne* en 1791 — elle sera guillotinée en 1793.\n- L'esclavage ne sera aboli qu'en 1794 (puis rétabli par Napoléon en 1802, définitivement aboli en 1848).",
            'chapitre_id' => $revCh3->id,
            'ordre'       => 1,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'Les 5 articles fondamentaux de la DDHC',
            'texte'            => "Article | Principe\n1       | Liberté et égalité naturelles de tous les hommes\n2       | Droits naturels : liberté, propriété, sûreté, résistance à l'oppression\n3       | Souveraineté nationale\n9       | Présomption d'innocence\n11      | Liberté d'expression et de presse\n\nInfluence directe :\n• Constitution française de 1958 (préambule y fait référence)\n• Déclaration universelle des droits de l'homme de 1948 (ONU)\n• Constitutions de nombreux pays francophones\n\nClassée au Registre Mémoire du Monde de l'UNESCO depuis 2003.",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $revSc3_1->id,
        ]);

        $revSc3_2 = SousChapitre::create([
            'titre'       => 'Influence de la Révolution dans le monde',
            'contenu'     => "La Révolution française a eu un impact mondial durable.\n\n## En Europe\n- Les guerres révolutionnaires puis napoléoniennes diffusent les idées de **liberté, égalité, nationalisme** dans toute l'Europe.\n- Elles inspirent les révolutions de **1830 et 1848** (Printemps des peuples).\n- Le **Code civil napoléonien** (1804), héritier direct de la Révolution, est adopté ou imité dans des dizaines de pays.\n\n## En Amérique latine\n- Les Révolutions d'indépendance (Haïti 1804, Simón Bolívar, José de San Martín) s'inspirent directement des principes de 1789.\n- **Haïti** (1804) devient la première République noire du monde, abolissant l'esclavage — en réponse directe aux idéaux révolutionnaires.\n\n## Dans le monde arabe et africain\n- Le nationalisme arabe du XXe siècle s'appuie sur les idées de souveraineté populaire.\n- Les mouvements de décolonisation des années 1950–1960 revendiquent les droits de 1789.\n\n## La devise française\n**Liberté – Égalité – Fraternité** est née dans la Révolution et demeure la devise officielle de la France depuis 1880.",
            'chapitre_id' => $revCh3->id,
            'ordre'       => 2,
        ]);

        ContenuPedagogique::create([
            'titre'            => 'L\'héritage révolutionnaire – Bilan',
            'texte'            => "Héritage positif :\n• Droits de l'homme et du citoyen → socle du droit moderne\n• Fin de la féodalité et des privilèges de naissance\n• Souveraineté populaire → démocratie représentative\n• Séparation des pouvoirs → système constitutionnel\n• Code civil (1804) → base juridique de 30+ pays\n\nHéritage controversé :\n• La Terreur → débat sur les limites des révolutions\n• Centralisation excessive de l'État\n• Exclusion des femmes et maintien (temporaire) de l'esclavage\n\nDevise héritée : LIBERTÉ – ÉGALITÉ – FRATERNITÉ",
            'lien_ressource'   => null,
            'sous_chapitre_id' => $revSc3_2->id,
        ]);

        $revQuiz3 = Quiz::create([
            'titre'            => 'Quiz – Héritage révolutionnaire',
            'sous_chapitre_id' => $revSc3_1->id,
        ]);

        $revQuestionsQuiz3 = [
            ['texte' => "Quel article de la DDHC consacre la présomption d'innocence ?",
             'reponses' => [['texte'=>'Article 1','est_correcte'=>false],['texte'=>'Article 3','est_correcte'=>false],['texte'=>'Article 9','est_correcte'=>true],['texte'=>'Article 11','est_correcte'=>false]]],
            ['texte' => "Qui a rédigé la Déclaration des droits de la femme et de la citoyenne en 1791 ?",
             'reponses' => [['texte'=>'Marie-Antoinette','est_correcte'=>false],['texte'=>'Olympe de Gouges','est_correcte'=>true],['texte'=>'Madame Roland','est_correcte'=>false],['texte'=>'Charlotte Corday','est_correcte'=>false]]],
            ['texte' => "Quelle est la devise officielle de la France héritée de la Révolution ?",
             'reponses' => [['texte'=>'Honneur et Patrie','est_correcte'=>false],['texte'=>'Dieu et le Roi','est_correcte'=>false],['texte'=>'Liberté Égalité Fraternité','est_correcte'=>true],['texte'=>'Force et Justice','est_correcte'=>false]]],
            ['texte' => "Quel pays est devenu en 1804 la première République noire du monde ?",
             'reponses' => [['texte'=>'Cuba','est_correcte'=>false],['texte'=>'Haïti','est_correcte'=>true],['texte'=>'Sénégal','est_correcte'=>false],['texte'=>'Jamaïque','est_correcte'=>false]]],
            ['texte' => "En quelle année l'esclavage est-il définitivement aboli en France ?",
             'reponses' => [['texte'=>'1794','est_correcte'=>false],['texte'=>'1815','est_correcte'=>false],['texte'=>'1848','est_correcte'=>true],['texte'=>'1870','est_correcte'=>false]]],
        ];

        foreach ($revQuestionsQuiz3 as $revQData) {
            $revQ = Question::create(['texte' => $revQData['texte'], 'quiz_id' => $revQuiz3->id]);
            foreach ($revQData['reponses'] as $revR) {
                Reponse::create(['texte' => $revR['texte'], 'est_correcte' => $revR['est_correcte'], 'question_id' => $revQ->id]);
            }
        }
    }
}
