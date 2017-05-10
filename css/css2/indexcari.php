<!DOCTYPE html> 
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>Template for Bootstrap</title>

    <!-- Bootstrap core CSS --> 
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
    
    <!-- Styles for textbox autocomplete -->
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
    <!--Bootstrap datepicker--!>
   <link href="bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
   <!--Theme layer paralax-->
   <link rel="stylesheet" type="text/css" media="screen" href="css/sequencejs-theme.sliding-horizontal-parallax.css" />
   <!-- align layout 2 column-->
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

  <!--stye form-->>
  <link href="css/form.css" rel="stylesheet">
  <style>
   #kanan
   {
   width:100%;
   position: absolute;
   top :70px; 
   z-index: 1;
   }    
   #kiri
   {
 }
 </style>
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls=
            <span class="sr-only">Toggle navigation</span>
          
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>  
<div id="kiri">
    <div class="container">
    <div class="starter template">

    <div class="container">
      <br> 
<div id="first">
<form  action="indexhasil.php" method="POST" id="form1">
<img id="logo" src="img/online.png"> 
        <br><br>
         <h6>
     <b><i class="fa fa-plane" ></i> Cari Jadwal Pesawat</h6></b>
         <!-- <input type="radio" id="onetrip"  title="Sekali Jalan">-->
   <div class="form-group">
       <br>
       <label for="txtNamaKota" >From :</label>
       <input placeholder="Ketik nama kota" class="form-control input-sm bg-info" id="d" name="d" type="text"/>
   </div>
    <div class="form-group">
       <label for="txtNamaKota2" >To :</label>
       <input placeholder="Ketik nama kota" class="form-control input-sm bg-info" id="a" name="a" type="text"/>
    </div>
<fieldset>
     <div class="form-group">
      <div class="input-group date form_date col-md-5"
      data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
    <!--form tanggal -->
    <label for="dtp_input2" class="col-md-2 control-label">Depart:</label>
     <input placeholder="choose depart date..." class="form-control" size="12" type="text" id="tanggal" name="tanggal">
     <span class="input-group-addon">
                 <span class="glyphicon glyphicon-calendar"></span></span>

  </div>
            <input class="form-control" type="hidden" id="dtp_input2" value=""/>
<div class="form-group">
      <div class="input-group date form_date col-md-5"
        data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
       <!--form tanggal -->
      <label for="dtp_input2" class="col-md-2 control-label">Return:</label>
       <input placeholder="choose date return..." class="form-control" size="12" type="text" id="tanggal" name="tanggal2">
         <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span></span>
                             
      </div>                 
                             
                             
         <input id="submit" type="submit" value="Cari">
 </fieldset>
            </form>
        </div>
<!--</table>-->
</div>
</div>
</section>

<section id="tab2">
    <h2><a href="#tab2">Tab 2</a></h2>
        <p>This content appears on tab 2.</p>
          </section>
            
</article>  
</div><!-- /.container -->
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.min.js.1"></script>
    <script type="text/javascript" src="jquery-1.8.3.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="bootstrap.min.js"></script>
     <script type="text/javascript" src="js/jquery.js"></script>   
     <script type="text/javascript" src="js/jquery-ui.js"></script>
     <script>
      var arrNamaKota = ["Ambon(AMQ)","Alor(ARD)","Anggi(AGD)","Arso(ARJ)","Atambua(ABU)",
                        "Babo(BXB)","Bali(DPS)","Balikpapan(BPN)","Banda Aceh(BTJ)","Bandar Lampung(TKG)",
                        "Bandung(BDO)","Bangkok(DMK)","Banjarmasin(BDJ)","Batam(BTH)","Bajawa(BJW)","Bau-bau(BUW)","Buli(WUB)",
                       "Bengkulu(BKS)","Berau(BEJ)","Biak(BIK)","Bima(BMU)","Bintuni(NTI)",
                        "Buol(UOL)","Banyuwangi(DQJ)",
                       "Cirebon(CBN)","Cilacap(CXP)","Cengkareng(CGK)", "Ciamis(NSW)",
                        "Dabo Singkep(SQI)","Denpasar(DPS)", "Djambi(DJB)", "Djayapura(DJJ)", "Dili(DIL)",
                        "Enarotali(EWI)","Ende(ENE)","Galela(GLX)","Gebe(GBE)","Gorontalo(GTO)","Gunung Sitoli(GNS)",
                         "Halim(HLP)","Hat Yai(HDY)","Ho Chi Minh City(SGN)",
                          "Inanwatan(INX)","Ipoh(IPH)","Jakarta-Cengkareng(JKT)","Jakarta-HalimPerdanaKusuma(HLP)","Jambi(DJB)",
                          "Jayapura(DJJ)","Jember(JBB)","Jogjakarta(JOG)","JohorBaru(JHB)","Kaimana(KNG)","Karimunjawa(KWB)",   
                          "Kendari(KDI)","Kerinci(KRC)","Ketapang(KTG)","Kualalumpur(KUL)","Kupang(KOE)","Kambuaya(KBX)",       
                          "Kebar(KEQ)", "Kepi(KEI)", "Kiman(KMM)", "Kotabaru(KBU)","Labuhan Bajo(LBJ)","Larantuka(LKA)",        
                          "Lewoleba(LOW)","Lubuklinggau(LLG)","Luwuk(LUW)",
                           "Lahore(LHE)","Lampung(TKG)","Langgur(LUV)", "Langkawi(LGK)","Larnaca(LCA)", "Lereh(LHI)",
                             "Lhokseumawe(LSW)","Lombok(LOP)", "Luyuk(LYK)","Malang(MLG)","Makasar(UPG)","Mamuju(MJU)","Manado(MDC)",
                             "Manokwari(MKW)","Masamba(MXB)","Mataram(AMI)","Malacca(MKZ)","Maumere(MOF)","Medan(KNO)","Melonguane(MNA)",
      "Manokwari(MKW)","Masamba(MXB)","Mataram(AMI)","Malacca(MKZ)","Maumere(MOF)","Medan(KNO)","Melonguane(MNA)",
                            "Merauke(MKQ)","Mangole(MAL)", "Morotai(OTI)","Matak(MWK)","Natuna(NTX)","Nunukan(NNX)","Nabire(NBX)",
                            "Namlea(NAM)","Namrole(NRE)","Numfor Timur","Nias(GNS)","Okaba(OKQ)", "Oksibil(OKL)","Padang(PDG)",   
                            "Palangka Raya(PKY)","Palu(PLW)","Pangkalan Bun(PKN)","Pangkalpinang(PGK)","Palembang(PLM)",
                             "Pekanbaru(PKU)","Penang(PEN)","Pinangsori(FLZ)", "Pomalaa(PUM)","Pontianak(PNK)","Poso(PSJ)", "Pangandaran(NSW)",
                           "Papua(DJJ)","Purwokerto(PWL)","PutusSibau(PSU)","Raha(RAQ)","Rote(RTI)","Ruteng(RTG)","Rengat(RGT)",
                          "Samarinda(SRI)","Sampit(SMQ)","Sanana(SQN)","Sarmi(ZRM)","Saumlaki(SXK)","Selayar(YKR)","Semarang(SRG)","Serui(ZRI)",
                         "Sibolga(AEG)","Silangit(DTB)","Simeuleu(SMG)","Singapore(SIN)","Singkep(SIQ)","Solo(SOC)","Sorong(SOQ)","Sumbawa(SWQ)",
                          "Sawu(SAU)","Sinak(NKD)","Surabaya(SUB)","Tahuna(NAH)","Taliabu(TAX)","Tanah Merah(TMH)","Tanjung Pandan(TJQ)",
                          "Tanjung Karang(TKG)", "Tawau(TWU)", "Tarakan(TRK)","Terengganu(TGG)","Ternate(TTE)","Tobelo(KAZ)","Toli(TLI)",
                          "Timika(TIM)","Ujungpandang(UPG)","Wamena(WMX)","Wangi-wangi(WGI)", "Yogyakarta(JOG)"];
  $(document).ready(function() {
   $("#d").autocomplete({
                           source: arrNamaKota
         });                 
        });                  


</script>
<script> 
      var arrNamaKota2 = ["Ambon(AMQ)","Alor(ARD)","Anggi(AGD)","Arso(ARJ)","Atambua(ABU)",
                        "Babo(BXB)","Bali(DPS)","Balikpapan(BPN)","Banda Aceh(BTJ)","Bandar Lampung(TKG)",
                        "Bandung(BDO)","Bangkok(DMK)","Banjarmasin(BDJ)","Batam(BTH)","Bajawa(BJW)","Bau-bau(BUW)","Buli(WUB)",
                       "Bengkulu(BKS)","Berau(BEJ)","Biak(BIK)","Bima(BMU)","Bintuni(NTI)",
                        "Buol(UOL)","Banyuwangi(DQJ)",
                       "Cirebon(CBN)","Cilacap(CXP)","Cengkareng(CGK)", "Ciamis(NSW)",
                        "Dabo Singkep(SQI)","Denpasar(DPS)", "Djambi(DJB)", "Djayapura(DJJ)", "Dili(DIL)",
                        "Enarotali(EWI)","Ende(ENE)","Galela(GLX)","Gebe(GBE)","Gorontalo(GTO)","Gunung Sitoli(GNS)",
                         "Halim(HLP)","Hat Yai(HDY)","Ho Chi Minh City(SGN)",
                          "Inanwatan(INX)","Ipoh(IPH)","Jakarta-Cengkareng(JKT)","Jakarta-HalimPerdanaKusuma(HLP)","Jambi(DJB)",
                          "Jayapura(DJJ)","Jember(JBB)","Jogjakarta(JOG)","JohorBaru(JHB)","Kaimana(KNG)","Karimunjawa(KWB)",   
                          "Kendari(KDI)","Kerinci(KRC)","Ketapang(KTG)","Kualalumpur(KUL)","Kupang(KOE)","Kambuaya(KBX)",
                          "Kebar(KEQ)", "Kepi(KEI)", "Kiman(KMM)", "Kotabaru(KBU)","Labuhan Bajo(LBJ)","Larantuka(LKA)", 
                          "Lewoleba(LOW)","Lubuklinggau(LLG)","Luwuk(LUW)",
                           "Lahore(LHE)","Lampung(TKG)","Langgur(LUV)", "Langkawi(LGK)","Larnaca(LCA)", "Lereh(LHI)",
                             "Lhokseumawe(LSW)","Lombok(LOP)", "Luyuk(LYK)","Malang(MLG)","Makasar(UPG)","Mamuju(MJU)","Manado(MDC)",
                             "Manokwari(MKW)","Masamba(MXB)","Mataram(AMI)","Malacca(MKZ)","Maumere(MOF)","Medan(KNO)","Melonguane(MNA)",
                            "Merauke(MKQ)","Mangole(MAL)", "Morotai(OTI)","Matak(MWK)","Natuna(NTX)","Nunukan(NNX)","Nabire(NBX)",
                            "Namlea(NAM)","Namrole(NRE)","Numfor Timur","Nias(GNS)","Okaba(OKQ)", "Oksibil(OKL)","Padang(PDG)",   
                            "Palangka Raya(PKY)","Palu(PLW)","Pangkalan Bun(PKN)","Pangkalpinang(PGK)","Palembang(PLM)",
  "Pekanbaru(PKU)","Penang(PEN)","Pinangsori(FLZ)", "Pomalaa(PUM)","Pontianak(PNK)","Poso(PSJ)", "Pangandaran(NSW)",
                           "Papua(DJJ)","Purwokerto(PWL)","PutusSibau(PSU)","Raha(RAQ)","Rote(RTI)","Ruteng(RTG)","Rengat(RGT)",
                          "Samarinda(SRI)","Sampit(SMQ)","Sanana(SQN)","Sarmi(ZRM)","Saumlaki(SXK)","Selayar(YKR)","Semarang(SRG)","Serui(ZRI)",
                         "Sibolga(AEG)","Silangit(DTB)","Simeuleu(SMG)","Singapore(SIN)","Singkep(SIQ)","Solo(SOC)","Sorong(SOQ)","Sumbawa(SWQ)",
                          "Sawu(SAU)","Sinak(NKD)","Surabaya(SUB)","Tahuna(NAH)","Taliabu(TAX)","Tanah Merah(TMH)","Tanjung Pandan(TJQ)",
                          "Tanjung Karang(TKG)", "Tawau(TWU)", "Tarakan(TRK)","Terengganu(TGG)","Ternate(TTE)","Tobelo(KAZ)","Toli(TLI)",
                          "Timika(TIM)","Ujungpandang(UPG)","Wamena(WMX)","Wangi-wangi(WGI)", "Yogyakarta(JOG)"];
  $(document).ready(function() {   
   $("#a").autocomplete({
                           source: arrNamaKota2
         });
        }); 


</script>

<script type="text/javascript" src="bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="bootstrap-datetimepicker.id.js" charset="UTF-8"></script>
    
    
    <script type="text/javascript">
   
     $('.form_date').datetimepicker
         ({
               language:  'id',
                weekStart: 1,  
                 todayBtn:  1, 
                  autoclose: 1,
                  todayHighlight: 1,
                    startView: 2,   
                      minView: 2,   
                       forceParse: 0
            });
               
    </script>  
<script src="js/jquery.sequence-min.js"></script>
<script src="js/sequencejs-options.sliding-horizontal-parallax.js"></script>

<div id="kanan">
<div id="sequence">
 <img class="sequence-prev" src="img/bt-prev.png" alt="Previous" />
        <img class="sequence-next" src="img/bt-next.png" alt="Next" />
      
  <ul class="sequence-canvas"> 
      <li class="animate-in">      
      <div class="info">
      <h2>Built using Sequence.js</h2>
     <p>The Responsive Slider with Advanced CSS3 Transitions</p>
      </div>
      <img class="sky" src="img/bg-clouds.png" alt="Blue Sky" />
      <img class="balloon" src="img/balloon.png" alt="Balloon" />
       </li> 

  <li>
    <div class="info">
      <h2>Creative Control</h2>
      <p>Create unique sliders using CSS3 transitions -- no jQuery knowledge required!</p>
    </div>
   <img class="sky" src="img/bg-clouds.png" alt="Blue Sky" />
   <img class="aeroplane" src="img/aeroplane.png" alt="Aeroplane" />
    </li>
     <li>
   <div class="info">   
     <h2>Cutting Edge</h2>
     <p>Supports modern browsers, old browsers (IE7+), touch devices and responsive designs</p>
  </div>
  <img class="sky" src="img/bg-clouds.png" alt="Blue Sky" />
  <img class="kite" src="img/kite.png" alt="Kite" />

    </li>
      </ul>    
        </div>
 </div>
  </body>
</html>   
