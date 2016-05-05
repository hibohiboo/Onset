#--*-coding:utf-8-*--

class Nuekagami < DiceBot
  
  def initialize
    super
  end
  
  
  def prefixs
    [] + @@tables.keys
  end
  
  def gameName
    '鵺鏡'
  end
  
  def gameType
    "Nuekagami"
  end
  
  def getHelpMessage
    return <<MESSAGETEXT
・喪失表（xL）
　BL：血脈、LL：生様、SL：魂魄、FL：因縁
・LR：喪失取戻表
・門通過描写表（xG）
　HG：地獄門、RG：羅生門、VG：朱雀門、OG：応天門
MESSAGETEXT
  end
  
  def rollDiceCommand(command)
    info = @@tables[command.upcase]
    return nil if info.nil?
    
    name = info[:name]
    type = info[:type]
    table = info[:table]
    
    text, number = 
      case type
      when '1D20'
        get_table_by_nDx(table, 1, 20)
      else
        nil
      end
    
    return nil if( text.nil? )
    
    return "#{name}(#{number}) ＞ #{text}"
  end
  
  
  @@tables =
    {
    "LR" => {
      :name => "喪失取戻表",
      :type => '1D20',
      :table => %w{
鬼化。妄執かくして鬼と結実す。欠けたるところすでになし。あやかし、己の欠けたるを足せり。すなわちその身、人ならず。
妄想。とくと見よ。何も失ってなどおらぬ。この肉この魂この身上、欠けたるところぞなし。欠けし夢を見しのみ。全て夢なり。
鵺型。肉に内に暗雲ゆらめく。欠けたるところ漂うそれは、鶴が欠片。暖昧の境界なれば、失いしものまた戻りたるが如く。
諦観。己が身を知る。望む愚かを知る。足掻く愚かを知る。心は折れり。望みは絶えり。諦めることで足るものもある知らむ。
屍漁。もはやいかな所業もいとわず。されば数多の骸を漁り、ついに欠けたるを満たせり。代わりに欠けたる心、知ることぞなし。
呪刻。あまねく呪はば、己も囚わる。己を騙る呪い、己を捕らえ絡めれば、欠けたるもまた満ちて見ゆる。
得心。すべては己の行いの結果なれば、因果応報。それなきは不具合なれど、得心せり。もはや悩めどせんなきことなりや。
奪取。無ければ、奪え。あな妬ましと思わば奪え。奪いて己がものとせよ。さすればたちまち、欲するところ戻れり。
罪価。己が罪を知れり。かくあさましき罪業に比ぶれば、己が失いしもの、なんと軽きことか。さあれば、悩むるに能はず。
代替。失へるもの、未だ失われり。されど、代わるものを得たり。二度とは失うわじ。失わばその痛みに狂い果てむ。
受容。納得はなし。諦観はなし。されど受け入れり。欠けたるもまた己なれば、欠けるところもて満たさば、それ己ならずや。
代行。かかる身にそれなくとも是。かく行い為すは、己が筆ならず。代わりて為す者、信ずべきあらばこそ。
適応。心痛むる時多けれど、欠けたるにも馴れたり。もはや欠けるに不自由なし。さればそれすなわち、欠けたるに非ず
妖賞。大妖に遇ひて、饗応す。彼の妖、大いに慶びてその身に欠けたるを与へむ。それ異様なれど、用は足れり。
奪還。つひに奪われしもの、奪い返せり！取り戻せしそれ、再び手の内に収まりて輝けり。けしてまた手放すことあらじ。
本懐。己の求むるを、ついに為し遂げり。もはや己が力、己が技、疑うところなし。己が有様になんぞ足らざるあるべきや。
取得。艱難辛苦ぞありや。ついぞ果てに失いしそれ、身に修めん。ただ取り戻せしものにあらじ。新たに得たりしや。
賜物。その欠ける様、彼の人あはれに思いて、かくなるを与え賜り。以て、満ちたる己、彼の人にまた仕えむ。
大悟。足掻けれど足掻けれど、満ちることなし。足りざるは自然。己の姿を受け入れむ。されば欠けたるに、悩まさるるもなし。
望月。欠けたる月が満ちるが如く。欠けたるは突然に戻れり。いかなる誠、いかなる印か、知るものはあらず。
},},
    
    "BL" => {
      :name => "血脈の喪失表",
      :type => '1D20',
      :table => %w{
髪の色。一夜にしてあなたの髪は白くなった。
視力。周囲がぼんやりとしか見えない。
所作。体の一部がまともに動かせない。
痛み。体が痛みを感じなくなってしまった。
容貌。顔に大きな傷や火傷を負った。
血の気。あなたの肌は血の気を失ったままだ。
赤い血。体を流れる血が異様な色となった。
子を作る力。子を作る力を失った。
器用さ。体が常に小さく震えている。
健康。病を患った……体が衰弱している。
寿命。あなたの寿命は残りわずかとなった。
ぬくもり。その体は常に冷たい……。
片目。片目を失ってしまった……。
片脚。片脚を切り落とされた！
片腕。片腕を切り落とされた！
生命。あなたの鼓動は止まって久しい。
真の力。本来の力がほとんど発揮できない。
肉。異様に痩せたか、体の一部が白骨化している。
人の体。体が歪み変わり、異形と化した。
己の体。今は他人の体を借りている。
},},
    
    
    "LL" => {
      :name => "生様の喪失表",
      :type => '1D20',
      :table => %w{
主君の寵愛。不興を買ってしまった。
師匠。死んだか、あるいはあなたが捨てられた。
面子。大いに恥をかいた。このままにしておけない。
時間。今まで精魂を傾けて来たものは無駄だった。
血縁。信じていた生まれではなかった……。
家宝。家の宝、あるいは形見を奪われてしまった。
恋人。死んだか、あるいは奪われた。
運。何をやってもうまくいかない。
財産。騙し取られたか……。あるいは使い果たした。
名声。あなたの名声は地に落ちている……。
居場所。居るべき場所、身分を失ってしまった……。
地位。かつての地位は失われたのだ。
日常。こんな世の中でも平和に暮らしていたのに。
相棒。死んだか、あるいは裏切られた。
仕える人。死んだか、あるいはあなたが捨てられた。
人望。かつてあなたを讃えた人が、今やあなたを罵る。
家族。死んだか、あるいはあなたが捨てられた。
故郷。何者かに滅ぼされたか、あるいは自滅した。
守るべき人。守るべき人を守れなかった……。
自由。脅され縛られ、誰かの命令を聞くしかできない。
},},
    
    
    "SL" => {
      :name => "魂魄の喪失表",
      :type => '1D20',
      :table => %w{
誇り。誇りなど残ってはいない。
心の余裕。今を生きるだけで精一杯。
敬う心。己こそが全てだ。
気力。何もやる気がおきない……。
安眠。夜毎の悪夢に、まともに眠れない。
信じる心。二度と人など信じるものか。
愛。もはや誰かを愛することなどない。
夢。前に見えていた光、目標。今は闇の中だ。
一線。己の中の超えてはならぬ線を踏み越えた。
信じたもの。かつて信じたのはまやかしだった。
人の心。この世で人の心が何の役に立つ？
瞳の光。全て虚しいものとしか見えない。
希望。この世に何を望むというのだろう？
自制心。己を抑えて何とする？
涙。その目が涙を流すことはない。
笑顔。二度と笑いなどしないだろう。
大切な記憶。どうしてか……記憶を失っている。
本当の自分。己を偽りすぎて、本来の己を忘れた。
正気。今のあなたは狂気の沙汰だ！
己の意志。あなたは誰かの人形。道具に過ぎない。
},},


    "FL" => {
      :name => "因縁表",
      :type => '1D20',
      :table => %w{
仇敵。奴は敵だ。あなたの敵だ。
殺意。殺してやりたい。
蔑視。口ほどにもない存在だ。
嫉妬。なぜアイツだけが……。
恐怖。恐ろしい。あれを怒らせてはいけない。
目障り。邪魔だ。気に入らない。
利用。役に立ってくれそうだな。
玩具。せいぜい楽しませてもらおう。
依存。あの人がいなければいけないのだ。
欲望。お前が欲しい……。
好敵。なかなかやるじゃないか。
憐憎。哀れな……。
悪友。腐れ縁。信用できないが妙に心地いい。
畏怖。あの人には逆らえない。
恩義。恩がある……返さなければ。
親友。心から信じられる友だ。
尊敬。あの人のようになりたい。
相棒。言葉はなくとも全てが通じ合う。
思慕。恋をしてしまった。
主君。心の主君。身命を賭して守り仕える。
},},


    "HG" => {
      :name => "地獄門通過描写表",
      :type => '1D20',
      :table => %w{
背後見れば、地獄の門をば幻視せり。危うき次第を知りたり．
必死に歩めり。背後に穂れし血と臓脈、こぼしたるが心地なれど。
背後の地に深き爪痕あり。己を捕らへむとせる鬼の爪跡かと思ふ。
劫火に焼かるる己を幻視す。汗にまみれ覚めれば、己が所業悔悟せり。
水鏡に映る己を見て目を覚ます。彼のままなれば地獄に堕つると。
天に鶴騒ぎたり。御身が魂晩取り逃がしたりと吃るが如く。
足が泥淳に囚わるる幻視。引きずり込む亡者。必死に逃れ至れり。
陰に蠢く餓鬼を見ゆ･明日は己ぞと思へば、背も震えたり。
喪失の苦しみ、いくばくか休めり。他を思う心地ぞ生まれり。
いみじう悩み苦しけれど、やがてそれも馴れり。今や苦しみならず。
しずけき雨降らば、己が所業洗い流さるるとも、思へたり。
汚泥が如く絡みし過ぎたる日々、わずかに離れたる心地ぞする。
背負いし怨念ら退き薄れむ。これなるは縁がゆへか、心地ゆへか。
内に孕むる絶望へ、連理たれと希望の芽、萌ゆる。
生温かき風と共に、大粒の雨降れり。すわ血の雨かとも思へり。
人と関わりて縁を見ゆ。抱ふるもの、いくらか少なくなりき。
夢枕、あるいは白昼夢なるか。神仏現るるにすがりたり。
劫火の中、白き手が己を引けりと幻視す。あるひは過去の縁か。
蛙呑む蛇を見たり。あさましき業に、己をふと顧みぬ。
心中にて、かそけき希望の糸見へり。慎重にたぐりて登らむとす。
},},


    "RG" => {
      :name => "羅生門通過描写表",
      :type => '1D20',
      :table => %w{
むごき所業、目にせり。心強張りて、常の様にてあれず．
人の目に、己を嗤ふ気配感じたり。怒り、悔み、恥ぞ覚えむ。
鬼の腕より、ついに逃るるか．おぞましき震へぞ、治まりき。
辻吹く風に、人骨散れり。たちまち無常の感、起こりて心改めたり。
愛憎恩普、いよいよ狂ほしく。猛るまま、ただただ前へと進めり。
飢えたる犬の如し。泥水すすりても前に進み、想い果たさむ。
喪失、取り戻すは近し。思はず、あさましき笑みぞ浮かべり。
いやしき者ども、あさましき目を向くる。蔑みてまかり通らむ。
喪失の夢繰り返すこといくたびか。もはや業苦の炎冷め、常日頃の如し。
あるひは己の内よりか。あやしき声あれば欲心また昂ぶらむ。
死人を見、成仏を祈れり。心あらば、己が内にて仏も宿らむ。
ただただ世の無常を知れば、哀愁の情あふれ感じむ。
路地に小さき花咲くを見ゆ。我執の心晴れたる心地せり。
冷たき風あらば、情動わずかに治まりて、落ち着きたりけり。
酒を飲めり。酔ひたる心地の内に、業苦も曖昧とならむ。
見えざる大門潜りしか。境目超えたるを感ずる。いざ、知らずの地平へ。
乞食坊主に逢ひて、恵む。これもまたいくばくの功徳なりきや。
子供ら遊ぶを見ゆ。己が古きを思へば、思はず顔ほころびぬ。
暗雲に包まれし都なれど今その身に、いくばくかの光差し照らしけり。
神仏の似姿、幻視す。されば、いかな身にも信心のいくばくか起これり。
},},


    "VG" => {
      :name => "朱雀門通過描写表",
      :type => '1D20',
      :table => %w{
雷響きて、暗霊いよいよ濃ゆし。己が先を見せるるが如し。
今一つ取り戻すは及ばぬ口惜しきに、鬼が如く唸りし。 
求めし手、届かずも絶望すれど再び、ふらふらと歩み出さむ。
かたときの福なるか。狐に化かさるるが如く、鹿なる泡沫の夢。 
流るる血。朱に染まる視界。されど、染まらざる中に光あり。
己が臓腑抉るが如く。己が業、抉り捨て進まん。
先に狐の影見ゆ。あやしけれど、迷ひながら、狐を追へり。
大いなる境を越えたるかと思えり。未だ道半ばなれば油断許さず。
暗雲に白鷺翔けるを見ゆ。瑞兆なれば希望もまた湧きぬ。
内より翼の出るが心地せり。いざ思い切りて、翔ばむ。
割れた杯より漏れたるも、重ねたる杯に。合一せば余さず受けり。
心激しくして魚跳ねるが如く。その実も暗き水面より跳ね出たり。
貴き牛車と行き逢はむ。幽かな香に、目ぞ覚めたる思いせり。
ふと口をついて歌詠めり。何者か下の句継ぎて、心合わせむ。
知らずの人より、送られし歌あり。返歌いかがせむかと思ひたり。
鳥の巣立つを見たり。己もまた、新たな道歩むべきぞと心せり。
暗雲貫きて、空に月あり。天より見らるる心地して、行い正せり。
目的近づけど、心重し。胸痛みて、いみじう哀し。
不意に仏心起こりて、万物慈みの念おぼえたり。
頭上より何者かの楽の音、饗けり。その身、祝はるる心地せり。
},},
    
    
    "OG" => {
      :name => "応天門通過描写表",
      :type => '1D20',
      :table => %w{
光捕らへど暗し。新たなる地獄の門に落つる己を知りたり。
求めしもの得たり。されど、なにものか失いし心地ぞせる……。
狐鴫きて自覚むる。全て一夜の夢の如し。痛みもまたしかり。
なにゆへか、涙こぼるる。ただ涙こぼれ、業苦もまた流れむ。
人想ひて、未練生まるる。己が幸求めれば、死を畏れむ。
打ち返す波の音聞く。遥か遠く、旅立ちたむと念、生じたり。
実る稲田を幻視す。もはや都の有様、人住む地に非ずと思へり。
取り戻したるに、ただただ歓喜す。もはや周りの様も感ぜず。
あまたの人の目、御身見てざわめくを感ず。優越の心地あり。
かけがへなきもの、見つけたり。今はただ、そを喜ぶのみなれば。
天盤にて星巡り、時満ちて、方合へり。なればその身にも幸ありむ。
幾年月ぞ、剥那の如し。思ふれば囚わる檻も、無きかと見ゆ。
天より鵺退きて、日の光差す。浴びる中、魂魄またぬくもりを覚えり。
風流、解する心あらば天地自然もまた並び、自らその内に合一せむ。
いかにせで、己の在り様を責むるや。己は己なれが、気に負うに値せず。
あまねく世のことども、遠く鈍く思ひて心安らかなる境地に至れり。
天遠く光差せば、淡き虹も浮かべり。何処かへ渡す橋とも見ゆ。
天より一輪の花舞い降りて、御身の手に落つ。心また花咲けり。
鵺の内に竜神舞へり。風雨激しく、身濡らせど、心清々し。
都の暗雲、晴れたる日も稀にあり。なんぞ魂魄晴るる日なしや。
},},



  }
end
