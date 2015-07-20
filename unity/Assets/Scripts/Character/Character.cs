using UnityEngine;
using UnityEngine.UI;
using System.Collections;
using System.Collections.Generic;

public abstract class Character : MonoBehaviour {
	protected Animator _Anim;
	protected BattleGround BG;
	private GameObject controller;
	private Slider HpBar;

	public int charId, side = 0;
	public int charNo, x, y, orgX, orgY;
	public string title, name, army;
	private Vector3 size;
	
	public int lv = 1;
	public int star = 1;
	public string type = "str";
	public int maxHp, hp = 300, en = 0, shield = 0;
	public int energyPool = 0, hurtPool = 0;		//損血計量
	public int str = 10, dex = 10, sta = 10, wit = 10;
	public int atk = 30, def = 10, res = 0, ap = 100, mp = 100, dp = 100, sp = 0, sdp = 0;
	public float moveSpeed = 2.0f, attackSpeed = 2.0f, attackTimer = 0.0f;
	protected int _atk, _def, _res, _ap, _mp, _dp, _sp, _sdp;
	public int _damage, _hurt, _recovery, _dodge, _crit;
	public int critRating = 0, dodgeRating = 0, hitRating = 0;
	public int _critRating, _dodgeRating, _hitRating;
	public float critRate = 2.0f;
	public float[] strRate = new float[5]{1.0f,1.5f,2.0f,2.5f,3.0f};
	public float[] dexRate = new float[5]{1.0f,1.5f,2.0f,2.5f,3.0f};
	public float[] staRate = new float[5]{1.0f,1.5f,2.0f,2.5f,3.0f};
	public float[] intRate = new float[5]{1.0f,1.5f,2.0f,2.5f,3.0f};
	public float hpRate, atkRate, defRate,resRate;
	public Dictionary<string, Dictionary<int, Buff>> buff = new Dictionary<string, Dictionary<int, Buff>>(){
		{"status", new Dictionary<int, Buff>()},
		{"damage", new Dictionary<int, Buff>()},
		{"recovery", new Dictionary<int, Buff>()},
		{"hurt", new Dictionary<int, Buff>()},
		{"heal", new Dictionary<int, Buff>()},
		{"end", new Dictionary<int, Buff>()},
		{"attr", new Dictionary<int, Buff>()},
		{"dodge", new Dictionary<int, Buff>()},
		{"crit", new Dictionary<int, Buff>()},
	};
	public Dictionary<string, Dictionary<int, Debuff>> debuff = new Dictionary<string, Dictionary<int, Debuff>>(){
		{"status", new Dictionary<int, Debuff>()},
		{"damage", new Dictionary<int, Debuff>()},
		{"recovery", new Dictionary<int, Debuff>()},
		{"hurt", new Dictionary<int, Debuff>()},
		{"heal", new Dictionary<int, Debuff>()},
		{"end", new Dictionary<int, Debuff>()},
		{"attr", new Dictionary<int, Debuff>()},
		{"dodge", new Dictionary<int, Debuff>()},
		{"crit", new Dictionary<int, Debuff>()},
	};
	/*
		0	=>	'status'
		1	=>	'damage'
		2	=>	'end'
		3	=>	'attr'
	*/


	public bool attacked = false;	//是否已攻擊
	public bool dead = false;		//是否陣亡
	public bool isComa = false;		//是否昏迷
	public bool isMove =false, isOver = false, isCastUltimate = false, isVisible = true;

	public Attack ultimate, skill1, skill2, skill3, skill4;
	public Attack attackMode;
	public int loopPos		=	0;
	public int[] attackLoop = new int[0];
	public Queue<popupText> damagePopupQueue = new Queue<popupText> ();
	protected Character[] _target;
	private int active;
	
	const float STAMINA_TO_HP = 18.0f;
	const float STRENGTH_TO_HP = 3.8f;
	const float MAIN_ATTR_TO_ATK = 0.56f;
	const float STRENGTH_TO_DEF = 0.28f;
	const float DEXTERITY_TO_DEF = 0.1f;
	const float STAMINA_TO_RES = 0.21f;
	const float INTELLECT_TO_RES = 1.0f;
	const float MAIN_ATTR_TO_AP = 3.0f;
	const float INTELLECT_TO_SP = 3.8f;
	const float INTELLECT_TO_MP = 2.4f;
	const float STRENGTH_TO_DP = 1.0f;
	const float DEXTERITY_TO_DP = 1.0f;
	const float STAMINA_TO_DP = 2.0f;
	const float INTELLECT_TO_SDP = 2.0f;
	const float STAMINA_TO_SDP = 2.0f;
	const float DEXTERITY_TO_CRIT = 0.82f;
	const float INTELLECT_TO_CRIT = 0.18f;
	const float DEXTERITY_TO_DODGE = 0.78f;
	const float INTELLECT_TO_DODGE = 0.22f;
	const float DEXTERITY_TO_HIT = 0.63f;
	const float INTELLECT_TO_HIT = 0.37f;
	const float LEVEL_TO_DAMAGE_REDUCTION = 40;
	const float LEVEL_TO_MAGIC_REDUCTION = 10;

	bool damagePopping = false;
	float timer = 0.0f;

//	public Vector3 mScreen;
//	public Vector2 mPoint;

	void Awake(){
		BG = BattleGround.Instance;
		this._Anim = GetComponent<Animator> ();
	}

	public Character init(Dictionary<string, int> option){
		this.charId 	= 	option["id"];
		this.charNo 	= 	option["charNo"];
		this.lv 		= 	option["lv"];

//		mScreen= Camera.main.WorldToScreenPoint(transform.position);
//		mScreen.y += 55;

//		transform.FindChild ("charCanvas").FindChild ("charName").transform.position = mScreen;
//		transform.FindChild ("charCanvas").FindChild ("charName").transform.GetComponent<UnityEngine.UI.Text>().text = this.title;

		int s = this.star - 1;
		string type = this.type;
		int mainAttr = 0;
		switch(type){
			case "str":
				mainAttr = this.str;
				break;
			case "dex":
				mainAttr = this.dex;
				break;
			case "int":
				mainAttr = this.wit;
				break;
		}

		this.str		=	(int)System.Math.Round(this.str + (this.lv - 1) * this.strRate[s]);
		this.dex		=	(int)System.Math.Round(this.dex + (this.lv - 1) * this.dexRate[s]);
		this.sta		=	(int)System.Math.Round(this.sta + (this.lv - 1) * this.staRate[s]);
		this.wit		=	(int)System.Math.Round(this.wit + (this.lv - 1) * this.intRate[s]);
		
		this.maxHp		=	this.hp		=	(int)System.Math.Round((this.hp + this.sta * STAMINA_TO_HP + this.str * STRENGTH_TO_HP) * this.hpRate);
		this._atk		=	this.atk	=	(int)System.Math.Round((this.atk + mainAttr * MAIN_ATTR_TO_ATK) * this.atkRate);
		this._def		=	this.def	=	(int)System.Math.Round((this.def + this.str * STRENGTH_TO_DEF + this.dex * DEXTERITY_TO_DEF) * this.defRate);
		this._res		=	this.res	=	(int)System.Math.Round((this.res + this.sta * STAMINA_TO_RES + this.wit * INTELLECT_TO_RES) * this.resRate);
		
		this._ap		=	this.ap		=	(int)System.Math.Round(this.ap + mainAttr * MAIN_ATTR_TO_AP);
		this._sp		=	this.sp		=	(int)System.Math.Round(this.sp + this.wit * INTELLECT_TO_SP);
		this._mp		=	this.mp		=	(int)System.Math.Round(this.mp + this.wit * INTELLECT_TO_MP);
		this._dp		=	this.dp		=	(int)System.Math.Round(this.dp + this.str * STRENGTH_TO_DP + this.dex * DEXTERITY_TO_DP + this.sta * STAMINA_TO_DP);
		this._sdp		=	this.sdp	=	(int)System.Math.Round(this.sdp + this.wit * INTELLECT_TO_SDP + this.sta * STAMINA_TO_SDP);
		
		this._critRating	=	this.critRating		=	(int)System.Math.Round(this.critRating + this.dex * DEXTERITY_TO_CRIT + this.wit * INTELLECT_TO_CRIT);
		this._dodgeRating	=	this.dodgeRating	=	(int)System.Math.Round(this.dodgeRating + this.dex * DEXTERITY_TO_DODGE + this.wit * INTELLECT_TO_DODGE);
		this._hitRating		=	this.hitRating		=	(int)System.Math.Round(this.hitRating + this.dex * DEXTERITY_TO_HIT + this.wit * INTELLECT_TO_HIT);

		GameObject hpBar = (GameObject) Instantiate (Resources.Load("Prefabs/HpBar"), transform.position, Quaternion.identity);
		hpBar.transform.SetParent (GameObject.Find("Canvas").transform, false);
		this.HpBar = hpBar.GetComponent<Slider> ();
		this.HpBar.maxValue = this.maxHp;
		this.HpBar.value = this.maxHp;

		Vector3 pos = Camera.main.WorldToScreenPoint (transform.position);
		pos.y -= 62.5f * this.BG.scale;
		this.HpBar.transform.position = pos;

		return this;
	}

	void Update () {
		if (isMove == true && transform.position != this.BG.map [this.x, this.y].transform.position) {
			transform.position = Vector3.MoveTowards (transform.position, this.BG.map [this.x, this.y].transform.position, (this.BG.dist / this.moveSpeed) * Time.deltaTime);
		}else if( this.isMove == true){
			this.isMove = false;
			this.nextMove();
		}else if(this.isMove == false && this.attacked == false){
			this.nextMove();
		}

		if (!this.attacked)
			this.attackTimer -= Time.deltaTime;

		if (this.damagePopupQueue.Count > 0 && !this.damagePopping)
			StartCoroutine ("damagePopup");
	}

	void LateUpdate(){
		Vector3 pos = Camera.main.WorldToScreenPoint (transform.position);
		pos.y -= 62.5f * this.BG.scale;
		this.HpBar.transform.position = pos;
	}

	public void startStep(){
		this.nextMove ();
	}

	private void nextMove(){
		bool flag = false;
		if (this.attackTimer <= 0.0f) {
			int key = (this.loopPos) % this.attackLoop.Length;
			this.active = this.attackLoop [key];
			

			switch (this.active) {
			case 1:
				flag = this.caseSkill1 ();
				break;
			case 2:
				flag = this.caseSkill2 ();
				break;
			case 3:
				flag = this.caseSkill3 ();
				break;
			case 4:
				flag = this.caseSkill4 ();
				break;
			}

			if (!flag)
				flag = this.attack ();

			if (flag) {
				this.addEnergy (15);
				this.activeSuccess ();
				this.attackTimer = this.attackSpeed;
			}
		}

		if (flag == false) {
			Step movePos = this.BG.getMovePath (this);
			if (movePos != null) {
				this.BG.map [this.x, this.y].clearChar ();
				this.BG.map [movePos.X, movePos.Y].setChar (this);
				this.moveTo (movePos);
			}
		}
	}

	public void moveTo(Step pos){
		this.setPos(pos.X, pos.Y);
		this.isMove = true;
	}

	public bool attackStep(){
		if(!this.isComa){
			if(!this.attacked){
				int key = (this.loopPos) % this.attackLoop.Length;
				this.active = this.attackLoop[key];

				bool flag = false;
				switch(this.active){
				case 1:
					flag = this.caseSkill1();
					break;
				case 2:
					flag = this.caseSkill2();
					break;
				case 3:
					flag = this.caseSkill3();
					break;
				case 4:
					flag = this.caseSkill4();
					break;
				}

				if(!flag)
					flag = this.attack();
				if(flag){
					this.addEnergy(15);
					this.activeSuccess();
					return true;
				}
			}
		}else{
			this.activeSuccess();

			Dictionary<string, string> data = new Dictionary<string, string>();
			data.Add("title", this.side.ToString() + " - " + this.title + this.name);
			data.Add("charId", this.side.ToString() + "-" + this.charId.ToString());
			data.Add("status", "昏迷");
			BG.addMessage("status", data);
		}
		return false;
	}

	public bool endStep(){
		//計算結束回合的debuff
		this.buffEffect("end");
		this.debuffEffect("end");
		
		//回合結束時，一次性扣掉血量
		this.shield -= this.hurtPool;
		if (this.shield < 0) {
			this.hp += this.shield;
			this.shield = 0;
		}

		this.hurtPool = 0;
		if(this.hp > this.maxHp)
			this.hp = this.maxHp;

		this.setHpBar ();

		if(this.hp <= 0 && !this.dead){
			this.die();
			return true;	//有死人就回傳true，讓外面做戰鬥結束的判斷
		}
		
		this.processBuff();
		
		//回合結束時，增加能量
		this.en += this.energyPool;
		this.energyPool = 0;
		if(this.en > 100) this.en = 100;
		if(this.side == 1)
			this.controller.transform.FindChild("enBar").transform.GetComponent<Slider> ().value = this.en;

		//還原角色狀態
		this.isComa = false;
		return false;
	}

	public bool attack(){
		this._target = this.BG.getTarget(this, this.attackMode);
		if (this._target != null && this._target.Length > 0) {
			_Anim.SetTrigger ("attack");
			return true;
		} else {
			return false;
		}
	}

	public void over(){
		this.isOver = true;
	}

	void die(){
		this.dead = true;
		BG.map[this.x, this.y].GetComponent<Ground>().clearChar();

		Dictionary<string, string> data = new Dictionary<string, string>();
		data.Add("charId", this.side.ToString() + '-' + this.charId.ToString());
		data.Add("title", this.side.ToString() + " - " + this.title + this.name);
		BG.addMessage("dead", data);
		_Anim.SetTrigger ("die");
	}

	void disappear(){
		Destroy(this.HpBar.gameObject);
		gameObject.SetActive (false);
	}
	
	public void damage(Character[] target, Attack spell = null){
		bool dodge = false;
		bool crit = false;
		int damaged = 0;
		if(spell == null)
			spell = this.attackMode;
		else
			spell.action = 2;

		switch(spell.prop){
			case 1:
			case 3:
				damaged = (int) System.Math.Round(this.atk * spell.rate);
				break;
			case 2:
			case 4:
				damaged = (int) System.Math.Round(this.mp * spell.rate);
				break;
			default:
				break;
		}

		foreach(Character t in target){
			Buff buff = null;
			Debuff debuff = null;
			if(spell.prop == 1)	//物理攻擊進行閃避判斷
				dodge  = this.isDodge(t);
			
			if(!dodge){	//沒閃掉的話進行傷害計算及暴擊判定
				this._damage = this.calcDamage(damaged, t, spell.prop);
				this.buffEffect("damage");
				this.debuffEffect("damage");
				crit   = this.isCrit(t, spell.prop);
				if(crit)
					this._damage = (int) System.Math.Round(this._damage * this.critRate);
				t.hurt(new popupText(){type=1,value=this._damage, isCrit=crit}, this);

				if(spell.buff > 0){
					buff = t.addBuff(this, spell.buff);
					if(spell.buffInstantly)
						buff.effectInstantly();
				}
				if(spell.debuff > 0)
					debuff = t.addDebuff(this, spell.debuff);
					if(spell.debuffInstantly)
						debuff.effectInstantly();
			}

			Dictionary<string, string> data = new Dictionary<string, string>();
			data.Add("action", spell.action.ToString());
			data.Add("prop", spell.prop.ToString());
			data.Add("attkerId", this.side.ToString() + '-' + this.charId.ToString());
			data.Add("attkerTitle", this.side.ToString() + " - " + this.title + this.name);
			data.Add("targetId", t.side.ToString() + '-' + t.charId.ToString());
			data.Add("targetTitle", t.side.ToString() + " - " + t.title + t.name);
			data.Add("title", spell.title);
			data.Add("damage", t._hurt.ToString());
			data.Add("isCrit", crit.ToString());
			data.Add("isDodge", dodge.ToString());
			data.Add("buff", (buff != null)? string.Format("{0} ({1})", buff.title, buff.duration.ToString()):"");
			data.Add("debuff", (debuff != null)? string.Format("{0} ({1})", debuff.title, debuff.duration.ToString()):"");

			BG.addMessage("attack", data);
		}
	}

	public void hurt(popupText damage, Character character = null){
		this.dot (damage, character);
		this.addEnergy(15);
	}

	public void dot(popupText damage, Character character = null){
		this._hurt = damage.value;
		this.buffEffect("hurt");
		this.debuffEffect("hurt");

		damage.value = this._hurt;
		this.damagePopupQueue.Enqueue (damage);	//傷害文字佇列

		//回合結束時，一次性扣掉血量
		this.shield -= this._hurt;
		if (this.shield < 0) {
			this.hp += this.shield;
			this.shield = 0;
		}

		this.setHpBar ();
		
		if(this.hp <= 0 && !this.dead){
			this.die();
		}
	}

	public Buff addBuff(Character caster, int no){
		GameObject buffPrefabs = (GameObject) Resources.Load(string.Format ("Prefabs/Buff/Buff_{0}", no));
		GameObject buffObject = (GameObject) Instantiate(buffPrefabs, new Vector3(0,0,0), Quaternion.identity);
		buffObject.transform.SetParent(transform, false);
		Buff buff = buffObject.GetComponent<Buff> ().init (this, caster);
		if (this.buff [buff.type].ContainsKey(no))
			this.buff [buff.type][no] = buff;
		else
			this.buff[buff.type].Add(no, buff);
		return buff;
	}

	public Debuff addDebuff(Character caster, int no){
		GameObject debuffPrefabs = (GameObject) Resources.Load(string.Format ("Prefabs/Debuff/Debuff_{0}", no));
		GameObject debuffObject = (GameObject) Instantiate(debuffPrefabs, new Vector3(0,0,0), Quaternion.identity);
		debuffObject.transform.SetParent(transform, false);
		Debuff debuff = debuffObject.GetComponent<Debuff> ().init (this, caster);
		if (this.debuff [debuff.type].ContainsKey(no))
			this.debuff [debuff.type][no] = debuff;
		else
			this.debuff[debuff.type].Add(no, debuff);
		return debuff;
	}

	public void processBuff(){
		foreach(KeyValuePair<string, Dictionary<int, Buff>> buffset in this.buff){
			List<int> doneBuff = new List<int>();
			foreach(KeyValuePair<int, Buff> buff in buffset.Value){
				if(buff.Value != null && buff.Value.nextRound())
					doneBuff.Add(buff.Key);
			}

			doneBuff.ForEach(delegate(int key){
				this.debuff[buffset.Key].Remove(key);
			});
		}

		foreach(KeyValuePair<string, Dictionary<int, Debuff>> debuffset in this.debuff){
			List<int> doneDebuff = new List<int>();
			foreach(KeyValuePair<int, Debuff> debuff in debuffset.Value){
				if(debuff.Value != null && debuff.Value.nextRound())
					doneDebuff.Add(debuff.Key);
			}

			doneDebuff.ForEach(delegate(int key){
				this.debuff[debuffset.Key].Remove(key);
			});
		}
	}
	
	public void buffEffect(string type){
		foreach(KeyValuePair<int, Buff> buff in this.buff[type]){
			if(buff.Value != null && buff.Value.isEnable)
				buff.Value.effect();
		}
	}
	
	public void debuffEffect(string type){
		foreach(KeyValuePair<int, Debuff> debuff in this.debuff[type]){
			if(debuff.Value != null && debuff.Value.isEnable)
				debuff.Value.effect();
		}
	}

	//動作完成
	void activeSuccess(){
		this.attacked = true;
        this.loopPos++;
//		this.over ();
	}

	//施放動畫結束
	void activeFinish(){
		this.attacked = false;
	}

	void addEnergy(int num){
		this.energyPool += num;
	}
	
	//重置屬性
	void resetAttr(){
		this.atk			=	this._atk;
		this.def			=	this._def;
		this.res			=	this._res;
		this.ap				=	this._ap;
		this.sp				=	this._sp;
		this.mp				=	this._mp;
		this.dp				=	this._dp;
		this.sdp			=	this._sdp;
		this.critRating		=	this._critRating;
		this.dodgeRating	=	this._dodgeRating;
		this.hitRating		=	this._hitRating;

		this._damage = 0;
		this._hurt = 0;
		this._recovery = 0;
		this._target = null;
	}

	public Character setArmy( int armyId){
		GameObject armyPrefabs = (GameObject) Resources.Load(string.Format ("Prefabs/Army/Army_{0}", armyId.ToString ()));
		GameObject army = (GameObject) Instantiate(armyPrefabs, new Vector3(0,0,0), Quaternion.identity);
		army.transform.SetParent(transform, false);
		army.GetComponent<Army> ().init ();
		return this;
	}

	public Attack getAttackRange(){
		return this.attackMode;
	}

	public int[] getPos(){
		return new int[2]{x, y};
	}

	public Character setPos(int x, int y){
		this.orgX = this.x;
		this.orgY = this.y;
		this.x = x;
		this.y = y;
		return this;
	}

	public Character setController(GameObject controller){
		this.controller = controller;
		this.controller.transform.GetComponent<UnityEngine.UI.Image>().sprite = this.transform.GetComponent<SpriteRenderer>().sprite;
		this.controller.transform.GetComponent<charController>().character = this;
		this.controller.transform.FindChild("hpBar").transform.GetComponent<Slider> ().maxValue = this.maxHp;
		this.controller.transform.FindChild("hpBar").transform.GetComponent<Slider> ().value = this.maxHp;
		return this;
	}

	public Character setSide(int side){
		this.side = side;
		return this;
	}

	/*
	params:
		damage:		基礎傷害
		&defender:	防禦方角色件
		spell:		施放的技能
	*/
	public int calcDamage(int damage, Character defender, int attackProp){
		float rate = 1.0f;
		if(attackProp == 1){
			damage = (int) System.Math.Round(damage * (1 - defender.def / (defender.def + defender.lv * LEVEL_TO_DAMAGE_REDUCTION)));
			rate =	this.ap / defender.dp;
		}else{
			damage = (int) System.Math.Round(damage * (1 - defender.res / (defender.res + defender.lv * LEVEL_TO_MAGIC_REDUCTION)));
			rate =	this.sp / defender.sdp;
		}
		if(rate > 1.5f)
			rate = 1.5f;
		else if(rate < 0.5f)
			rate = 0.5f;
		damage = Random.Range(damage, (int) System.Math.Round(damage * rate));
		return damage;
	}

	public bool canCastUltimate(){
		if (this.side == 1) {
			return (!this.dead && this.ultimate != null && en >= 100 && isCastUltimate && !this.isComa) ? true : false;
		} else {
			return (!this.dead && this.ultimate != null && en >= 100 && !this.isComa)?true:false;
		}
	}

	//是否已完成攻擊, 僅用於移動回合判斷
	public bool isAttacked(){
		return this.attacked;
	}


	public bool isCrit(Character target, int attackProp){
		this._crit = 0;
		if(attackProp == 1){
			this._crit = (int) System.Math.Floor(((this.critRating * (1 + (this.lv - target.lv) * 0.05)) / (this.lv * 0.38) + 5) * 100);
		}else{
			this._crit = (int) System.Math.Floor(((this.critRating * (1 + (this.lv - target.lv) * 0.05)) / (this.lv * 0.38) + 5) * 100);
		}
		this.buffEffect("crit");
		this.debuffEffect("crit");
		if(Random.Range(0,10000) < this._crit)
			return true;
		return false;
	}
	
	public bool isDodge(Character target){
		this._dodge = (int) System.Math.Floor(((target.dodgeRating * (1 + (this.lv - target.lv) * 0.05) - this.hitRating) / (this.lv * 0.34) + 5) * 100);
		this.buffEffect("dodge");
		this.debuffEffect("dodge");
		if(Random.Range(0,10000) < this._dodge )
			return true;
		return false;
	}

	IEnumerator damagePopup(){
		this.damagePopping = true;
		popupText damage = this.damagePopupQueue.Dequeue ();
		GameObject damagePopup = (GameObject) Instantiate(Resources.Load("Prefabs/DamagePopup"), transform.position, Quaternion.identity);
		damagePopup.transform.SetParent (GameObject.Find("Canvas").transform, false);
		damagePopup.transform.position = Camera.main.WorldToScreenPoint (transform.position);
		damagePopup.GetComponent<DamagePopup>().damage = damage;
		yield return new WaitForSeconds (0.3f);
		this.damagePopping = false;
	}

	void setHpBar(){
		if (this.hp < 0)
			this.hp = 0;
		this.HpBar.value = this.hp;
		if(this.side == 1)
			this.controller.transform.FindChild("hpBar").transform.GetComponent<Slider> ().value = this.hp;
	}

	virtual public void dealDamage(){
		switch(this.active){
			case 0:
				this.damage(this._target);
				break;
			case 1:
				this.damage(this._target, this.skill1);
				break;
			case 2:
				this.damage(this._target, this.skill2);
				break;
			case 3:
				this.damage(this._target, this.skill3);
				break;
			case 4:
				this.damage(this._target, this.skill4);
				break;
			case 99:
				this.damage(this._target, this.ultimate);
				break;
		}

	}

	virtual public void appear(){}	//角色出現的時候，用來設定被動技能的效果
	virtual public void castUltimate(){
		this._target = this.BG.getTarget(this, this.ultimate);
		if (this._target != null && this._target.Length > 0) {
			this.active = 99;
			_Anim.SetTrigger ("castUltimate");
			this.en = 0;
			this.isCastUltimate = false;
			this.activeSuccess();
		} else {
			this.endCastUltimate();
		}
	}
	virtual public void endCastUltimate(){
//		this.BG.castUltimate ();
	}
	virtual public bool caseSkill1(){
		this._target = this.BG.getTarget(this, this.skill1);
		if(this._target != null && this._target.Length > 0){
			_Anim.SetTrigger ("castSkill");
			return true;
		}
		return false;
	}

	virtual public bool caseSkill2(){
		this._target = this.BG.getTarget(this, this.skill2);
		if(this._target != null && this._target.Length > 0){
			_Anim.SetTrigger ("castSkill");
			return true;
		}
		return false;
	}

	virtual public bool caseSkill3(){
		this._target = this.BG.getTarget(this, this.skill3);
		if(this._target != null && this._target.Length > 0){
			_Anim.SetTrigger ("castSkill");
			return true;
		}
		return false;
	}

	virtual public bool caseSkill4(){
		this._target = this.BG.getTarget(this, this.skill4);
		if(this._target != null && this._target.Length > 0){
			_Anim.SetTrigger ("castSkill");
			return true;
		}
		return false;
	}
}