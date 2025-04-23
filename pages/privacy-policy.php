<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";

//HEADER 
setHeaders([
    "meta-title" => "Privacy Policy",
    "meta-robots" => "noindex"
]);

/* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
if ($_POST['spa']) security_uri($_POST['urlrewrite']);
/* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
?>
<div class="blur-backdrop overflow-hidden wow fadeIn">
    <div class="container py-4 px-3 px-lg-0">
        <h2 class="fw-semibold mb-4 text-center">Privacy Policy</h2>
        <hr>
        <div class="row gy-5 fs-6">
            <div class="col-12">
                <h4 class="fw-bold">Informazioni sul trattamento dei dati personali ai sensi degli articoli 13 e 14 del Reg. UE n. 679/2016</h4>
                <p>
                    RoundTwo S.r.l. raccoglie ed utilizza i tuoi dati personali quando navighi o usufruisci dei servizi online presenti sul
                    sito <a href="https://finalround.it/">https://finalround.it/</a><br>
                    Con dato personale intendiamo ogni informazione che può essere utilizzata per identificarti come individuo.
                    Lo scopo di questa informativa è fornirti una chiara e dettagliata spiegazione di come, quando e perché
                    raccogliamo ed utilizziamo i tuoi dati. Essa è stata concepita per esporti in modo semplice e trasparente la
                    nostra politica in materia di protezione dei dati personali e illustrarti come esercitare in maniera efficace i
                    tuoi diritti.<br>
                    Queste informazioni si riferiscono soltanto ai dati trattati da RoundTwo S.r.l. tramite questo Sito web e non
                    riguardano altri siti web, piattaforme o pagine di social network eventualmente raggiungibili tramite link
                    presenti sul Sito web: in questi casi, è sempre necessario fare riferimento alle informazioni disponibili sulle
                    rispettive pagine.<br>
                    Queste informazioni potrebbero subire delle modifiche e delle variazioni nel tempo, per cui ti invitiamo a
                    consultare regolarmente questa pagina per essere aggiornato sui trattamenti di dati personali effettuati.
                </p>
            </div>
            <div class="col-12">
                <h4 class="fw-bold">INDICE</h4>
                <ol>
                    <li><a href="privacy-policy#1" class="text-primary">Chi è il titolare del trattamento?</a></li>
                    <li><a href="privacy-policy#2" class="text-primary">Quando raccogliete i miei dati?</a></li>
                    <li><a href="privacy-policy#3" class="text-primary">Quali dati possiamo raccogliere?</a></li>
                    <li><a href="privacy-policy#4" class="text-primary">Devo per forza fornirvi i miei dati?</a></li>
                    <li><a href="privacy-policy#5" class="text-primary">Per cosa tratterete i miei dati?</a></li>
                    <li><a href="privacy-policy#6" class="text-primary">Per quali scopi ulteriori potrete utilizzare i miei dati?</a></li>
                    <li><a href="privacy-policy#7" class="text-primary">Con chi condividerete i miei dati?</a></li>
                    <li><a href="privacy-policy#8" class="text-primary">In che modo tratterete i miei dati?</a></li>
                    <li><a href="privacy-policy#9" class="text-primary">I miei dati vengono trattati in ambito extra europeo?</a></li>
                    <li><a href="privacy-policy#10" class="text-primary">Link a siti terzi e social network</a></li>
                    <li><a href="privacy-policy#11" class="text-primary">Quali sono i miei diritti e come posso tutelare la mia privacy?</a></li>
                    <li><a href="privacy-policy#12" class="text-primary">Posso presentare un reclamo?</a></li>
                    <li><a href="privacy-policy#13" class="text-primary">Eventuali modifiche</a></li>
                </ol>
            </div>
            <div id="1" class="col-12">
                <h4 class="fw-bold">1. Chi è il titolare del trattamento dei miei dati?</h4>
                <p>
                    Poiché RoundTwo S.r.l., P.I. 03905980128, determina i mezzi e le finalità del trattamento dei dati personali
                    coinvolti nell’utilizzo di questo Sito web, è il Titolare del Trattamento.
                    Puoi contattare il Titolare del Trattamento inviandogli una comunicazione ai seguenti indirizzi:
                </p>
                <ul>
                    <li>via posta: RoundTwo S.r.l., Viale Ippolito Nievo 24 21052, Busto Arsizio (VA);</li>
                    <li>e-mail: privacy@finalround.it</li>
                </ul>
            </div>
            <div id="2" class="col-12">
                <h4 class="fw-bold">2. Quando raccogliete i miei dati?</h4>
                <p>RoundTwo S.r.l. raccoglierà le informazioni da te direttamente fornite:</p>
                <ul>
                    <li>quando accedi e navighi sul sito;</li>
                    <li>quando invii delle domande o dei consigli attraverso le sezioni o i contatti a ciò dedicati;</li>
                    <li>quando chiedi assistenza sui nostri servizi;</li>
                    <li>quando prenoti le postazioni di streaming;</li>
                    <li>quando commenti le nostre notizie e i nostri contenuti.</li>
                </ul>
            </div>
            <div id="3" class="col-12">
                <h4 class="fw-bold">3. Quali dati possiamo raccogliere?</h4>
                <p>
                    Quando interagisci con noi, attraverso il Sito Web (utilizzando cookie o altre tecnologie di tracciamento, come
                    indicato nella Cookie policy) o i contatti indicati (mail, social), potresti fornirci i seguenti tipi di informazioni
                    personali:
                </p>
                <ul>
                    <li>Dati identificativi: nome, cognome, nickname, lingua, descrizione personale;</li>
                    <li>Dati di contatto: indirizzo e-mail, canali social.</li>
                </ul>
                <p>
                    Invece, se non fornisci il consenso tramite l’apposito banner, le seguenti informazioni saranno sempre
                    raccolte solo in forma aggregata che non ci permette di risalire a te:
                </p>
                <ul>
                    <li>Dati di utilizzo del Sito: informazioni su come utilizzi il nostro sito Web, incluso il tempo trascorso sulla pagina, i click-through, gli errori di download, il traffico, i dati di comunicazione e le risorse a cui accedi;</li>
                    <li>Dati tecnici: indirizzo IP, tipo di browser, tipo e numero di hardware, identità di rete e software, informazioni sul dispositivo, posizione e impostazione del fuso orario, sistema operativo e configurazione del sistema.</li>
                </ul>
            </div>
            <div id="4" class="col-12">
                <h4 class="fw-bold">4. Devo per forza fornirvi i miei dati?</h4>
                <p>
                    Il conferimento dei dati e il relativo trattamento sono obbligatori in relazione alle finalità di seguito indicate
                    e ai servizi da te richiesti.<br>
                    Puoi navigare sul sito senza fornirci alcuna informazione (ad eccezione dei dati di navigazione raccolti dai
                    cookies tecnici funzionali, raccolti e conservati come indicato nella Cookie policy, a cui facciamo ora rinvio).<br>
                    Se invece decidi spontaneamente di contattarci, interagire con le nostre attività o sui nostri canali social,
                    prenotare eventi e postazioni, alcuni dati personali verranno necessariamente raccolti e utilizzati per poter
                    eseguire le tue richieste: sarà sempre evidente quali dati saranno richiesti e non raccoglieremo dati ulteriori
                    senza il tuo consenso
                </p>
            </div>
            <div id="5" class="col-12">
                <h4 class="fw-bold">5. Per cosa tratterete i miei dati?</h4>
                <p>
                    Quando navighi, navighi o usufruisci dei servizi sul sito di RoundTwo S.r.l., potranno essere trattate le seguenti tipologie di dati:
                </p>
                <ol style="list-style: lower-alpha;">
                    <li class="mb-3">
                        <h6><b>Navigazione</b></h6>
                        <p>
                            Alcuni dati personali la cui trasmissione è implicita nella navigazione dei siti web, inclusi ma non limitati al
                            traffico dati e riguardanti la localizzazione, il weblog e altri dati di comunicazione per eventuali scopi di
                            fatturazione o riguardanti le risorse a cui accedi tramite il dispositivo, vengono acquisiti dai sistemi informatici
                            che consentono ne consentono il corretto funzionamento. Anche se queste informazioni non sono raccolte
                            per essere associate a interessati identificati, potrebbero permettere di identificare gli utenti - per loro stessa
                            natura e attraverso elaborazioni ed associazioni con dati detenuti da terzi. Ad esempio, fra essi rientrano gli
                            indirizzi IP o i nomi a dominio dei computer utilizzati dagli utenti che si connettono al Sito, gli indirizzi univoci
                            delle risorse richieste, l’orario della richiesta, il metodo utilizzato nel sottoporre la richiesta al server, la
                            dimensione del file ottenuto in risposta, il codice numerico indicante lo stato della risposta data dal server
                            ed altri parametri relativi al sistema operativo e al browser utilizzato.
                        </p>
                        <ul>
                            <li>Finalità del trattamento: consentirti un utilizzo sicuro e corretto del Sito web;</li>
                            <li>Base giuridica del trattamento: il legittimo interesse di RoundTwo S.r.l. al corretto funzionamento del Sito web e alla sicurezza della navigazione, regolarmente bilanciato con i diritti dell’interessato (art. 6, comma 1, lett. f, GDPR).</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <h6><b>Richiesta di informazioni tramite le sezioni dedicate</b></h6>
                        <p>
                            Puoi contattarci tramite utilizzando i recapiti indicati sul sito per richiedere informazioni o assistenza; ciò
                            comporta la successiva acquisizione dei dati che ci hai comunicato (nome, cognome, indirizzo e-mail e le
                            informazioni riportate nella comunicazione) e, ovviamente, comporta che ci permetti di inviarti eventuali
                            comunicazioni di risposta utilizzando i recapiti che ci hai fornito al momento della richiesta.
                        </p>
                        <ul>
                            <li>Finalità del trattamento: assicurarti adeguato supporto in relazione alle tue necessità e dare riscontro alle tue richieste;</li>
                            <li>Base giuridica del trattamento: la prestazione del servizio che hai richiesto (art. 6, comma 1, lett. b, GDPR).</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <h6><b>Prenotazioni</b></h6>
                        <p>
                            Compilando i moduli disponibili nel Sito o fornendo le informazioni indicate è possibile prenotare le aree
                            streaming o gli altri eventuali eventi messi a disposizione da RoundTwo S.r.l. I dati forniti saranno trattati dal personale
                            incaricato dal Titolare esclusivamente per gestire la tua richiesta. In caso di dubbi, vi invitiamo a contattare
                            direttamente RoundTwo S.r.l. per ogni chiarimento ai recapiti indicati sul Sito
                        </p>
                        <ul>
                            <li>Finalità del trattamento: gestire la richiesta di iscrizione e la successiva partecipazione al corso indicato dall’interessato;</li>
                            <li>Base giuridica del trattamento: la prestazione del servizio che hai richiesto (art. 6, comma 1, lett. b, GDPR).</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <h6><b>Invio di comunicazioni a fini di marketing nell’ambito dell’interesse legittimo e del soft-spam</b></h6>
                        <p>
                            In alcuni casi potremmo utilizzare l’indirizzo e-mail comunicato dall’utente utilizzando il sito per inviare
                            alcune comunicazioni, anche senza richiedere all’utente il preventivo consenso. Questo trattamento sarà
                            effettuato nel rispetto di quanto previsto dall’art. 6, lett. f), GDPR e dall’art. 130, co. 4, del d.lgs. 130/2003.
                            In particolare, gli utenti vengono informati dell’attività di trattamento tramite la presente informativa e viene
                            loro sempre riconosciuto il diritto di opporsi, in modo semplice e gratuito, a tale trattamento: ogni
                            comunicazione inviata dal Titolare, infatti, contiene il rinvio a queste informazioni e le indicazioni su come
                            richiedere l’interruzione del trattamento (mediante opt-out), contattando il Titolare o selezionando
                            direttamente l’apposito link messo a disposizione in fondo ad ogni comunicazione.
                        </p>
                        <ul>
                            <li>Finalità del trattamento: informarti su servizi analoghi a quelli che hai già richiesto e che possono quindi essere di tuo interesse;</li>
                            <li>Base giuridica del trattamento: la previsione normativa di cui all’art. 130, comma 4, d.lgs. 196/2003 che legittima l’invio di comunicazioni riguardanti prodotti o servizi analoghi a quelli già richiesti (art. 6, comma 1, lett. c ed f, GDPR).</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <h6><b>Cookie</b></h6>
                        <p>
                            Cosa sono? Con il termine cookie si indica un piccolo file di testo al cui interno sono memorizzate brevi
                            informazioni relative alla navigazione in un determinato sito internet, che verrà installato sul tuo dispositivo
                            nel momento in cui effettui l’accesso. Ogni cookie contiene diversi dati (ad es., il nome del server da cui
                            proviene, un identificatore numerico, ecc.), può rimanere nel sistema per la durata di una sessione (sino alla
                            chiusura del browser) o per lunghi periodi e può contenere un codice identificativo unico.
                            Quando visiterai nuovamente il sito, essi saranno reinoltrati al sito che li ha generati (cookie di prima parte)
                            o a quelli forniti da soggetti terzi in grado di riconoscerli (cookie di terze parti).
                            RoundTwo S.r.l. intende rassicurarti circa la sicurezza dei cookie presenti sul proprio sito web: essi non
                            danneggiano in alcun modo il tuo dispositivo, ma ti consentiranno di navigare più velocemente, offrendoti
                            un’esperienza migliore.
                        </p>
                        <p>
                            A cosa servono? I cookie sono utilizzati per diverse finalità a seconda della loro tipologia: alcuni sono
                            strettamente necessari per la corretta funzionalità di un Sito web (cookie tecnici), mentre altri ne ottimizzano
                            le prestazioni per offrire una migliore esperienza all’utente o consentono di acquisire statistiche sull’utilizzo
                            del Sito, come i cookie analytics, o consentono di visualizzare pubblicità personalizzata, come i cookie di
                            profilazione.
                        </p>
                        <p>
                            Il sito di RoundTwo S.r.l. potrebbe utilizzare sia cookie che non necessitano del tuo consenso per la loro
                            installazione (come i cookie tecnici), sia cookie che necessitano di un tuo preventivo consenso per poter
                            essere utilizzati (come i cookie di profilazione). Tale informazione viene riportata nel banner visualizzato in
                            apertura del Sito e nel pannello di impostazioni dei cookies sempre disponibile sul Sito.
                            In particolare, sul sito possono essere attivati:
                        </p>
                        <ol style="list-style: lower-alpha;">
                            <li class="mb-3">
                                <h6><b>Cookie tecnici (che NON richiedono il tuo consenso):</b></h6>
                                <p>
                                    Sono cookie necessari per il funzionamento del sito e ti permettono di accedere alle sue funzioni (c.d. cookie
                                    di navigazione) o di autenticarti nella sessione.<br>
                                    È previsto inoltre l’utilizzo di cookie funzionali, che consentono di memorizzare le tue preferenze e
                                    impostazioni, migliorando così la tua esperienza di navigazione all’interno del sito.
                                    Per garantire la loro funzionalità, di regola questi cookie non sono cancellati alla chiusura del browser; hanno
                                    tuttavia una durata predefinita (generalmente fino ad un massimo di 2 anni) e trascorso tale periodo si
                                    disattivano automaticamente. Questi cookie e i dati da essi raccolti non saranno in alcun modo utilizzati per
                                    scopi ulteriori.<br>
                                    L’installazione dei cookie tecnici avviene automaticamente a seguito dell'accesso al sito o per attivare
                                    determinate funzionalità (es. selezionando l’opzione "ricordami"). In qualsiasi momento puoi sempre
                                    decidere di disabilitarli modificando le impostazioni del tuo browser: in tal caso, potresti tuttavia riscontrare
                                    alcuni problemi nella visualizzazione del sito.
                                </p>
                                <ul>
                                    <li>Finalità perseguita: garantire il corretto funzionamento e la sicurezza del sito;</li>
                                    <li>Base giuridica del trattamento: il legittimo interesse di RoundTwo S.r.l. al corretto funzionamento del sito e alla sicurezza della navigazione, regolarmente bilanciato con i diritti dell’interessato (art. 6, comma 1, lett. f, GDPR).</li>
                                </ul>
                            </li>
                            <li class="mb-3">
                                <h6><b>Cookie analitici (che potrebbero NON richiedere il tuo consenso se anonimizzati):</b></h6>
                                <p>
                                    Questi cookie tengono traccia delle scelte effettuate sul sito e dei dati relativi alla navigazione online degli
                                    utenti (ad esempio, pagine visualizzate, tempi di sosta su una pagina, ecc.), al fine di effettuare analisi
                                    statistiche, normalmente in forma anonima e aggregata. Se gli utenti sono tracciabili e identificabili tramite
                                    queste analisi, questi strumenti possono essere utilizzati solo previa espressione del suo consenso.
                                    Quando invece ricorrono le seguenti circostanze:
                                </p>
                                <ul>
                                    <li>l’indirizzo IP è stato debitamente anonimizzato;</li>
                                    <li>le informazioni ricavate con i cookie analitici si riferiscono ad una sola risorsa informatica (sito, app, etc.) e vengano utilizzati solo in forma anonima ed aggregata;</li>
                                    <li>il provider dei cookie non combina le informazioni con altre elaborazioni e non li trasmette a terzi, viene garantita la completa anonimizzazione dei dati raccolti e anche i cookies rientranti in questa categoria potranno essere attivati senza necessità di un consenso da parte dell’utente, proprio perché i dati trattati non sono ricollegabili a nessun utente identificabile.</li>
                                    <li>Finalità perseguita: disporre di statistiche relative al comportamento degli utenti sul Sito, basate su dati aggregati e anonimizzati.</li>
                                    <li>
                                        Base giuridica del trattamento: a seconda dei casi:
                                        <ul>
                                            <li>
                                                il legittimo interesse di RoundTwo S.r.l. all’ottimizzazione delle prestazioni del Sito e al miglioramento
                                                dei servizi forniti tramite il Sito, regolarmente bilanciato con i diritti dell’interessato (art. 6, comma
                                                1, lett. f, GDPR);
                                            </li>
                                            <li>
                                                il consenso dell’utente (art. 6, comma 1, lett. a, GDPR), liberamente prestato e revocabile in ogni
                                                momento, tramite il banner dei cookies o seguendo le indicazioni riportate qui sotto e nella Cookie
                                                Policy.
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-3">
                                <h6><b> Cookie di profilazione e marketing (che richiedono il tuo CONSENSO):&nbsp;</b></h6>
                                <p>
                                    Questo sito utilizza anche cookie di profilazione e di terze parti, la cui installazione è subordinata al tuo consenso preventivo rilasciato tramite il banner o anche gestito in ogni momento attraverso la Cookie Policy.
                                    I cookie di profilazione possono comprendere diverse categorie, tra cui quelli di profilazione pubblicitaria, di retargeting o i cookie Social.
                                </p>
                                <ul class="mb-3">
                                    <li>Cookie di profilazione pubblicitaria: creano un profilo utente che ti consente la visualizzazione di contenuti pubblicitari in linea con le preferenze manifestate durante la navigazione nel sito;</li>
                                    <li>Cookie di retargeting: sono creati al fine di inviarti contenuti pubblicitari relativi ai prodotti che hai acquistato o visionato sul sito e verso i quali hai manifestato interesse;</li>
                                    <li>Cookie social: questo sito prevede l'installazione di cookie relativi ai plug-in dei social network. Tali cookie sono gestiti direttamente da terze parti e consentono la visualizzazione di messaggi pubblicitari in linea con tue le preferenze.</li>
                                </ul>
                                <p>
                                    Quando accedi al Sito, tramite un apposito banner verrai informato della presenza di cookie di profilazione e di retargeting e, attraverso esso, potrai acconsentire o meno alla loro installazione, selezionando eventualmente i singoli cookies che vuoi installare.
                                    In qualsiasi momento potrai comunque revocare il consenso precedentemente prestato, senza pregiudicare la possibilità di visitare il sito e di fruire dei relativi contenuti.
                                    L'installazione di cookie di profilazione, retargeting, analitici e social, compresa ogni altra attività a essi connessa, è gestita tramite servizi di terze parti. Per maggiori informazioni e per attivare o disattivare questi cookie, puoi accedere alle informative rese direttamente dalle società terze: il relativo elenco è a tua disposizione nella nostra Cookie Policy.
                                    L’utente viene informato sia mediante l’informativa breve (banner visualizzato sino a quando non viene prestato o negato il consenso) sia tramite la nostra Cookie Policy che ti invitiamo a leggere con attenzione per tutte le altre informazioni sui cookie utilizzati nel sito e per le informazioni sulla loro disabilitazione.
                                </p>
                                <ul>
                                    <li>Finalità perseguita: analizzare il comportamento di navigazione dell’utente per presentare pubblicità personalizzata;</li>
                                    <li>Base giuridica del trattamento: il consenso dell’utente (art. 6, comma 1, lett. a, GDPR), liberamente prestato e revocabile in ogni momento, tramite il banner dei cookies o seguendo le indicazioni riportate qui sotto e nella Cookie Policy.</li>
                                </ul>
                            </li>
                            <li>
                                <h6><b>Plugin per i social media</b></h6>
                                <p>
                                    Sul Sito sono presenti alcuni pulsanti che rinviano l’utente ai profili del Titolare sui social network. Solo a
                                    seguito di click su tali pulsanti, potrebbero essere attivati alcuni cookie per finalità di marketing e profilazione
                                    dalle terze parti che gestiscono i social network. Il Titolare del Sito non gestisce direttamente tali strumenti,
                                    ma ti informa della possibilità che, avvalendoti delle funzionalità del Sito, essi vengano attivati. Per maggiori
                                    informazioni, anche su come disabilitare tali cookie, ti invitiamo a leggere le informative sul trattamento dei
                                    dati personali dei social network:
                                </p>
                                <ul class="mb-3">
                                    <li> Instagram: <a href="https://help.instagram.com/519522125107875">https://help.instagram.com/519522125107875</a></li>
                                    <li>Twitch: <a href="https://www.twitch.tv/p/en/legal/privacy-notice/">https://www.twitch.tv/p/en/legal/privacy-notice/</a></li>
                                </ul>
                                <p>
                                    <u>Disabilitazione tramite browser</u><br>
                                    Ti segnaliamo che dal sito <a href="http://www.youronlinechoices.com/it/">http://www.youronlinechoices.com/it/</a> è possibile non solo acquisire ulteriori
                                    informazioni sui cookie, ma anche verificare l’installazione di numerosi cookie sul proprio
                                    browser/dispositivo e, ove supportato, anche di disabilitarli.
                                    I browser comunemente utilizzati (ad es., Internet Explorer, Firefox, Chrome, Safari), inoltre, accettano i
                                    cookie per impostazione predefinita, ma tale impostazione può essere modificata dall’utente in ogni
                                    momento. Ciò vale sia per i pc sia per i dispositivi mobile come tablet e smartphone: è una funzione
                                    generalmente e diffusamente supportata.<br>
                                    Pertanto, i cookie possono facilmente essere disattivati o disabilitati accedendo alle opzioni o alle preferenze
                                    del browser adoperato e generalmente possono essere bloccati anche i soli cookie di terze parti; in linea
                                    generale, tali opzioni avranno effetto solo per quel browser e su quel dispositivo, salvo che non siano attive
                                    opzioni per unificare le preferenze su dispositivi diversi. Le istruzioni specifiche possono essere reperite nella
                                    pagina delle opzioni o di aiuto (help) del browser stesso. La disabilitazione dei cookie tecnici, tuttavia, può
                                    influire sul pieno e/o corretto funzionamento di diversi siti, incluso questo Sito.<br>
                                    Di norma, i browser oggi adoperati:
                                </p>
                                <ul class="mb-3">
                                    <li>offrono l’opzione “Do not track”, che è supportata da alcuni siti web (ma non da tutti). In tal modo, alcuni siti web potrebbero non raccogliere più taluni dati di navigazione;</li>
                                    <li>offrono l’opzione di navigazione anonima o in incognito: in tal modo non saranno raccolti dati nel browser e non sarà salvata la cronologia di navigazione, ma i dati di navigazione saranno comunque acquisibili dal gestore del sito web visitato;</li>
                                    <li>consentono di eliminare i cookie memorizzati in tutto o in parte, ma alla nuova visita ad un sito web vengono di norma installati ove tale possibilità non venga bloccata.</li>
                                </ul>
                                <p>Si indicano i link alle pagine di supporto dei browser maggiormente diffusi (con istruzioni sulla disabilitazione dei cookie su tali browser):</p>
                                <ul>
                                    <li>Firefox (<a href="https://support.mozilla.org/it/kb/Attivare%20e%20disattivare%20i%20cookie">https://support.mozilla.org/it/kb/Attivare%20e%20disattivare%20i%20cookie);</a></li>
                                    <li>Microsoft Edge (<a href="http://windows.microsoft.com/it-it/internet-explorer/delete-manage-cookies#ie=ie11">http://windows.microsoft.com/it-it/internet-explorer/delete-manage-cookies#ie=ie11</a>);</li>
                                    <li>Safari (iOS) (<a href="https://support.apple.com/it-it/HT201265">https://support.apple.com/it-it/HT201265</a>);</li>
                                    <li>Chrome (desktop: <a href="https://support.google.com/chrome/answer/95647?hl=it">https://support.google.com/chrome/answer/95647?hl=it</a>; Android e iOS <a href="https://support.google.com/chrome/answer/2392971?hl=it">https://support.google.com/chrome/answer/2392971?hl=it</a>).</li>
                                </ul>
                            </li>
                        </ol>
                    </li>
                </ol>
            </div>
            <div id="6" class="col-12">
                <h4 class="fw-bold">6. Per quali scopi ulteriori potrete utilizzare i miei dati?</h4>
                <p>
                    I tuoi dati personali, infine, potranno essere utilizzati anche al fine di:
                </p>
                <ol style="list-style: lower-alpha;">
                    <li>ottemperare agli obblighi di legge e alle richieste provenienti da autorità pubbliche o governative;</li>
                    <li>gestire eventuali contestazioni o contenzioni e quindi difendere i diritti di RoundTwo S.r.l., sia in via giudiziale che stragiudiziale.</li>
                </ol>
                <p>In tali casi, le basi giuridiche del trattamento saranno:</p>
                <ul>
                    <li>per il punto a), l’adempimento di un obbligo di legge;</li>
                    <li>per il punto b), l’interesse legittimo del Titolare alla tutela dei propri diritti, purché adeguatamente bilanciati, di volta in volta, con i diritti dell’interessato.</li>
                </ul>
            </div>
            <div id="7" class="col-12">
                <h4 class="fw-bold">7. Con chi condividerete i miei dati?</h4>
                <p>
                    Nel rispetto delle finalità indicate alla precedente sezione, il personale di RoundTwo S.r.l. potrà essere incaricato
                    di trattare i tuoi dati, al fine di fornirti i servizi, le informazioni o il supporto richiesti.<br>
                    Pertanto, l’accesso ai tuoi dati personali sarà autorizzato espressamente dal Titolare del trattamento, il quale,
                    nel caso fosse necessario, potrà nominare i soggetti a cui si rivolge per la fornitura dei servizi e per le attività
                    di propria competenza quali Responsabili del trattamento a norma degli artt. 28 e 29 del GDPR.<br>
                    Ti ricordiamo, inoltre, che l’elenco dei responsabili del trattamento è disponibile presso il Titolare, a cui potrai
                    richiederglielo utilizzando i recapiti sopra indicati.<br>
                    I dati degli utenti non saranno in nessun caso ceduti a terzi ad eccezione del caso in cui lo richieda la natura
                    dei servizi resi, o del caso in cui, in virtù di un obbligo legale o in presenza di un suo legittimo interesse, il
                    Titolare abbia la necessità di comunicarli alle autorità giurisdizionali o di controllo competenti.
                </p>
            </div>
            <div id="8" class="col-12">
                <h4 class="fw-bold">8. In che modo tratterete i miei dati?</h4>
                <p>
                    I dati personali che raccoglieremo tramite la registrazione e la successiva partecipazione ai tornei verranno
                    trattati in forma informatizzata solamente dai soggetti espressamente autorizzati dal Titolare, di cui
                    quest’ultimo si avvale per il perseguimento delle attività di trattamento, designandoli, quando necessario,
                    come responsabili del trattamento.<br>
                    Le operazioni saranno effettuate anche con modalità parzialmente automatizzate, comunque nel rispetto
                    delle disposizioni di legge, e in grado di garantire la riservatezza, la sicurezza e l’esattezza dei dati, nonché la
                    limitazione e la pertinenza dei dati rispetto alle finalità perseguite. I dati comunicati potranno essere oggetto
                    di controlli amministrativi ed istituzionali da parte delle Autorità e degli Enti/Società preposti, anche al fine
                    di accertare il regolare svolgimento dell’iniziativa.<br>
                    I dati saranno conservati per i tempi necessari per le finalità del Sito, fatta salva la conservazione delle sole
                    informazioni necessarie al Titolare per dimostrare la corretta esecuzione delle procedure e il rispetto degli
                    obblighi previsti dalla legge.<br>
                    RoundTwo S.r.l. adotterà le misure tecniche e organizzative indispensabili ad impedire la perdita, l’uso illecito o non
                    corretto dei dati, oltre a prevenire qualsiasi forma di accesso non autorizzato da parte di terzi; RoundTwo S.r.l. garantirà
                    la sicurezza dei tuoi dati personali, limitando il numero di soggetti a cui sarà consentito l’accesso ai server o
                    ai database e predisponendo sistemi di protezione volti a ridurre il rischio di attacchi informatici.
                </p>
            </div>
            <div id="9" class="col-12">
                <h4 class="fw-bold">9. I miei dati vengono trattati in ambito extra europeo?</h4>
                <p>
                    I dati trattati da RoundTwo S.r.l. risiedono in server ubicati nel territorio europeo.
                    Qualora alcuni fornitori di servizi abbiano sede in paesi extraeuropei, ad esempio, negli Stati Uniti, i dati
                    personali potrebbero essere trasferiti anche in server ubicati negli Stati Uniti, considerato dalle Autorità
                    Garanti Europee come un paese che non offre delle garanzie di pari livello a quelle previste dal GDPR per la
                    protezione dei dati personali. In questi casi, quindi, il Titolare utilizzerà questi fornitori nel rispetto di quanto
                    previsto dagli articoli 45 e seguenti del GDPR. Saranno quindi adottate tutte le cautele necessarie al fine di
                    garantire la migliore protezione possibile dei dati personali basando tale trasferimento: a) su decisioni di
                    adeguatezza dei paesi terzi destinatari espressi dalla Commissione Europea; b) su garanzie adeguate espresse
                    dal soggetto terzo destinatario ai sensi dell’art. 46 del Regolamento; c) sull’adozione di norme vincolanti
                    d’impresa, cd. Corporate binding rules e, in particolare, predisponendo delle misure tecniche e informatiche
                    di sicurezza che tutelino nel migliore dei modi i dati personali e i diritti degli interessati, come previsto dal
                    GDPR e dalla normativa europea.
                </p>
            </div>
            <div id="10" class="col-12">
                <h4 class="fw-bold">10. Link a siti terzi e social network</h4>
                <p>
                    Il Sito web può contenere collegamenti da e verso i siti Web di nostri partner, nonché ad inserzionisti e a
                    social network. Si ricorda che il Titolare non assume alcuna responsabilità per i dati personali che potrebbero
                    essere raccolti tramite questi siti e l’utilizzo dei relativi servizi e che, se l’utente segue un collegamento a uno
                    qualsiasi di questi siti web, è invitato a consultare le Privacy policy rese da ciascun soggetto esterno rispetto
                    al Sito web.<br>
                    In particolare, quando tramite la funzione presente sul Sito, accedi al tuo account sulla piattaforma Twitch,
                    è necessario che tu faccia riferimento alla relativa Privacy policy (<a href="https://www.twitch.tv/p/en/legal/privacynotice/">https://www.twitch.tv/p/en/legal/privacynotice/</a>) per tutte le informazioni sul trattamento dei dati personali.
                </p>
            </div>
            <div id="11" class="col-12">
                <h4 class="fw-bold">11. Quali sono i miei diritti e come posso tutelare la mia privacy?</h4>
                <p>
                    In relazione ai tuoi dati personali ed in conformità con quanto previsto dal GDPR, RoundTwo S.r.l. ti informa che
                    hai il diritto di richiedere:
                </p>
                <ul>
                    <li>l’accesso ai tuoi dati;</li>
                    <li>la modifica e la rettifica di qualunque errore presente nei nostri database relativo ai tuoi dati;</li>
                    <li>la cancellazione dei tuoi dati qualora siano detenuti in assenza dei presupposti giuridici;</li>
                    <li>la limitazione del trattamento dei tuoi dati;</li>
                    <li>l’opposizione al trattamento dei dati;</li>
                    <li>la portabilità dei dati.</li>
                </ul>
                <p>
                    Eventuali modelli e maggiori informazioni sono inoltre disponibili qui:
                    <a href="https://www.garanteprivacy.it/web/guest/home/docweb/-/docweb-display/docweb/1089924">https://www.garanteprivacy.it/web/guest/home/docweb/-/docweb-display/docweb/1089924</a>.
                </p>
                <p>Nella seguente tabella ti illustriamo dettagliatamente come esercitare i diritti:</p>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">IL TUO DIRITTO</th>
                                <th scope="col">COME PUOI ESERCITARLO?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Accesso</b></td>
                                <td>
                                    <p>Puoi chiedere di:</p>
                                    <ul>
                                        <li><b>Chiedere conferma</b> su un eventuale trattamento riguardante i tuoi dati personali;</li>
                                        <li>Ottenere una <b>copia</b> dei tuoi dati;</li>
                                        <li><b>Fornirti altre informazioni sui tuoi dati personali</b> che non siano già presenti in questa informativa.</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Rettifica</b></td>
                                <td>
                                    <p>
                                        Puoi chiedere la <b>rettifica dei dati personali inesatti o incompleti</b>.<br>
                                        Prima di procedere con la rettifica, verificheremo l’accuratezza dei dati presenti nei
                                        nostri archivi.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Cancellazione/Diritto all’oblio</b></td>
                                <td>
                                    <p>Puoi richiedere la <b>cancellazione dei tuoi dati personali</b>, ma solo nel caso in cui:</p>
                                    <ul>
                                        <li>La loro permanenza <b>non sia più necessaria</b> in relazione agli scopi per i quali sono stati raccolti;</li>
                                        <li><b>Hai negato il tuo consenso precedentemente prestato</b> (laddove il trattamento sia basato sul consenso);</li>
                                        <li>Il trattamento sia stato effettuato in modo <b>illegittimo</b>;</li>
                                        <li><b>Sia necessario per ottemperare ad un obbligo legale</b> al quale RoundTwo S.r.l. è soggetta (in relazione ad un ordine proveniente da un’Autorità).</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Limitazione</b></td>
                                <td>
                                    <p>Puoi chiedere di limitare i tuoi dati personali, ma solo nel caso in cui:</p>
                                    <ul>
                                        <li><b>La loro esattezza sia stata già contestata;</b></li>
                                        <li><b>Non siano più necessari per le finalità per i quali erano stati raccolti</b>, ma è in atto una contestazione legale in merito al loro utilizzo;</li>
                                    </ul>
                                    <p><b>A seguito di una tua richiesta di limitazione, l’utilizzo dei i tuoi dati personali</b> è tuttavia <b>consentito</b> allorché:</p>
                                    <ul>
                                        <li><b>Permanga comunque il tuo consenso;</b></li>
                                        <li><b>Sia necessario per esercitare o resistere ad un’azione legale;</b></li>
                                        <li>Per tutelare <b>i diritti di un’altra persona fisica o giuridica coinvolta nel trattamento.</b></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Portabilità</b></td>
                                <td>
                                    <p>Puoi richiedere una copia dei tuoi dati personali in un formato strutturato, leggibile e di uso comune.</p>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Opposizione</b></td>
                                <td>
                                    <p>Puoi <b>opporti in qualsiasi momento al trattamento dei dati personali</b> che ti riguardano quando:</p>
                                    <ul>
                                        <li>la base di liceità del trattamento è <b>l’interesse legittimo</b> del titolare;</li>
                                        <li>i dati personali siano trattati per <b>finalità di marketing diretto</b> compresa la profilazione nella misura in cui sia connessa a tale marketing diretto.</li>
                                    </ul>
                                    <p>Quando ti opponi:</p>
                                    <ul>
                                        <li>al trattamento per finalità di marketing diretto, i dati personali <b>non saranno più oggetto di trattamento per tali finalità</b>;</li>
                                        <li>
                                            in caso di interesse legittimo del titolare, <b>il trattamento potrà continuare
                                                soltanto se egli dimostri l’esistenza di motivi legittimi cogenti per
                                                procedere</b> al trattamento che prevalgono sugli interessi, sui diritti e sulle
                                            libertà dell’interessato oppure per l’accertamento, l’esercizio o la difesa di
                                            un diritto in sede giudiziaria.
                                        </li>
                                    </ul>
                                    <p>
                                        <b>È possibile esercitare il diritto di opposizione anche con mezzi automatizzati</b> che
                                        utilizzano specifiche tecniche, come quelli messi a disposizione sul sito nella pagina
                                        personale e nelle e-mail (link per la cancellazione).
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p>RoundTwo S.r.l. garantisce che ad ogni istanza riguardante i tuoi diritti verrà dato riscontro entro trenta giorni dal suo ricevimento</p>
            </div>
            <div id="12" class="col-12">
                <h4 class="fw-bold">12. Posso presentare un reclamo?</h4>
                <p>
                    Hai il diritto di presentare un reclamo all’Autorità Garante della protezione dei dati personali, qualora tu
                    ritenga che il trattamento effettuato da RoundTwo S.r.l. non sia conforme alle prescrizioni del Regolamento
                    Europeo n. 679/2016 e della normativa nazionale.<br>
                    In Italia, l’autorità competente è il <b>Garante per la protezione dei dati personali</b>, i cui recapiti sono disponibili
                    all’indirizzo <a href="http://www.garanteprivacy.it/">http://www.garanteprivacy.it/</a>.<br>
                    Maggiori informazioni e il documento esemplificativo da utilizzare per il reclamo sono disponibili qui:
                    <a href="https://www.garanteprivacy.it/web/guest/home/docweb/-/docweb-display/docweb/4535524">https://www.garanteprivacy.it/web/guest/home/docweb/-/docweb-display/docweb/4535524</a>.<br>
                    Inoltre, qualora sussistano i presupposti previsti dagli artt. 78 e 79 del GDPR, hai il diritto di proporre un
                    ricorso dinanzi all’autorità giurisdizionale competente.
                </p>
            </div>
            <div id="13" class="col-12">
                <h4 class="fw-bold">13. Eventuali modifiche</h4>
                <p>
                    Le informazioni che ti stiamo fornendo ora possono essere modificate nel tempo, quando cambiano le attività
                    di trattamento, i dati raccolti oppure quando intervengono delle modifiche legislative o regolamentari, o in
                    occasione di evoluzioni tecnologiche. Ti consigliamo quindi di consultare periodicamente la presente Privacy
                    e cookie policy sempre aggiornata su questa pagina
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        gtag('js', new Date());
        gtag('config', 'G-F862ZC7SF3');
    });
</script>