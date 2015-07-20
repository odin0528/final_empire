using UnityEngine;
using UnityEngine.UI;
using System.Collections;
using System.Collections.Generic;

public class BattleGround : MonoBehaviour {
	public static BattleGround Instance;
	public GameObject roundCounter;
	public GameObject g_cell;		//底部單位元件
	public float screenWidth = 1920.0f;
	public float screenHeight = 1080.0f;
	public int width = 10;
	public int height = 5;
	public int moveCounter = 0, characterCount = 0;
	public int roundNumber = 0;
	public Character[] offensiveTeam = new Character[5];
	public Character[] defenderTeam = new Character[5];
	int[,] offensivePosition = new int[,] {{1,2},{0,1},{0,2}};
	int[,] defenderPosition = new int[,] {{8,2},{9,1},{9,3}};
	private float groundSize = 1.5f;
	private float groundPadding = 0.1f;
	public float dist;
	public float scale;
	public int step = 0;
	
	public int[] offensiveId = new int[5];
	public int[] defenderId = new int[5];
	public int[] offensiveLv = new int[5] {30,30,30,30,30};
	public int[] defenderLv = new int[5] {30,30,30,30,30};
	public int[] offensiveArmy = new int[5]{1,1,1,1,1};
	public int[] defenderArmy = new int[5]{1,1,1,1,1};
	
	public Ground[,] map;
	private bool someoneAttack = false;
	Queue<Character> castUltimateQueue = new Queue<Character>();
	
	void Awake(){
		Instance = this;
	}
	
	
	void Start () {
		this.scale = (float)Screen.width/screenWidth;
		this.dist = this.groundSize + this.groundPadding;
		//		this.scale = new Vector2((float)Screen.width/screenWidth, (float)Screen.height/screenHeight);
		//		GUIUtility.ScaleAroundPivot(this.scale,Vector2.zero);
		//		print (scale);
		
		generateBoard ();
		setOffensive ();
		setDefender ();

		StartCoroutine (waitForIt(1.5f, 1));
	}
	
	//產生空的盤面
	void generateBoard (){
		this.map = new Ground[this.width, this.height];
		// CleanBoard();
		for(int i=0;i<this.height;i++){
			for(int j=0;j<this.width;j++){
				float y = i * (this.groundSize + this.groundPadding) + 1.0f;
				float x = j * (this.groundSize + this.groundPadding) + 1.0f;
				GameObject cloneCell = (GameObject) Instantiate(g_cell, new Vector3(x, y, 0), transform.rotation);
				cloneCell.name = string.Format("Cell {0} - {1}", j, i);
				cloneCell.transform.SetParent(GameObject.Find("background").transform, false);
				map[j,i] = cloneCell.GetComponent<Ground>();
			}
		}
	}
	
	//設定進攻方
	void setOffensive (){
		for(int i=0;i < this.offensiveId.Length; i++){
			if(offensiveId[i] > 0){
				//取得站位
				int x = offensivePosition[i,0];
				int y = offensivePosition[i,1];
				
				//插入角色物件
				GameObject cloneCharacter = (GameObject) Instantiate(Resources.Load("Prefabs/Character/Char_" + offensiveId[i] + "/Character"), map[x,y].transform.position, transform.rotation);
				offensiveTeam[i] = cloneCharacter.GetComponent<Character>();
				cloneCharacter.name = string.Format("Offensive - {0}{1}", offensiveTeam[i].title, offensiveTeam[i].name);
				
				//設定角色參數
				Dictionary<string, int> option = new Dictionary<string, int> ();
				option.Add ("id", offensiveId[i]);
				option.Add ("charNo", offensiveId[i]);
				option.Add ("lv", offensiveLv[i]);
				
				int no = i+1;
				offensiveTeam[i].setArmy(offensiveArmy[i])
					.init(option)
						.setSide(1)
						.setPos (x, y)
						.setController(GameObject.Find("Canvas/characterController" + no.ToString()))
						.appear();
				
				//設定角色到地圖上
				this.map[x, y].GetComponent<Ground>().setChar(offensiveTeam[i]);
				
				Dictionary<string, string> data = new Dictionary<string, string>();
				data.Add ("title", string.Format("1 - {0}{1}", offensiveTeam[i].title, offensiveTeam[i].name));
				data.Add ("charId", string.Format("1-{0}", offensiveTeam[i].charId.ToString()));
				data.Add ("x", x.ToString());
				data.Add ("y", y.ToString());
				addMessage("battleStart", data);
			}else{
				int no = i+1;
				Destroy(GameObject.Find("Canvas/characterController" + no.ToString()));
			}
		}
	}
	
	//設定防禦方
	void setDefender (){
		for(int i=0;i < this.defenderId.Length; i++){
			if(defenderId[i] > 0){
				//取得站位
				int x = defenderPosition[i,0];
				int y = defenderPosition[i,1];
				
				//插入角色物件
				GameObject cloneCharacter = (GameObject) Instantiate(Resources.Load("Prefabs/Character/char_" + defenderId[i] + "/Character"), map[x,y].transform.position, transform.rotation);
				defenderTeam[i] = cloneCharacter.GetComponent<Character>();
				cloneCharacter.name = string.Format("Defender - {0}{1}", defenderTeam[i].title, defenderTeam[i].name);
				
				
				//設定角色參數
				Dictionary<string, int> option = new Dictionary<string, int> ();
				option.Add ("id", defenderId[i]);
				option.Add ("charNo", defenderId[i]);
				option.Add ("lv", defenderLv[i]);
				
				defenderTeam[i].setArmy(defenderArmy[i]).init(option).setSide(2).setPos (x, y).appear();
				
				//設定角色到地圖上
				this.map[x, y].GetComponent<Ground>().setChar(defenderTeam[i]);
				
				Dictionary<string, string> data = new Dictionary<string, string>();
				data.Add ("title", string.Format("2 - {0}{1}", defenderTeam[i].title, defenderTeam[i].name));
				data.Add ("charId", string.Format("2-{0}", defenderTeam[i].charId.ToString()));
				data.Add ("x", x.ToString());
				data.Add ("y", y.ToString());
				addMessage("battleStart", data);
			}
		}
	}
	
	IEnumerator waitForIt(float seconds, int step){
//		print ("wait for it");
		yield return new WaitForSeconds (seconds);
		switch(step){
		case 1:
			this.startStep();
			break;
		case 2:
			this.startStep ();
			break;
		}
	}
	
	void nextRound(){
		this.characterCount = 0;
		this.moveCounter = 0;
		this.someoneAttack = false;
		this.step = 1;
	}
	
	void startStep(){
		//回合開始時，所有角色進行處理狀態debuff buff
		foreach(Character character in offensiveTeam){
			if(character && !character.dead){
				character.startStep();
				this.characterCount++;
			}
		}
		
		foreach(Character character in defenderTeam){
			if(character && !character.dead){
				character.startStep();
				this.characterCount++;
			}
		}
	}
	
	//攻擊目標搜尋演算法
	public Character[] getTarget(Character character, Attack attack, int[] pos = null){
		
		//計算範圍的基準點
		int[] center = new int[2]{
			(pos != null)?pos[0]:character.x,
			(pos != null)?pos[1]:character.y
		};
		
		int[,] attackArea = attack.range;
		int[,] splash = (attack.splash != null)?attack.splash:null;
		
		string searchTarget = (attack.target != null && attack.target == "ally")? "ally":"enemy";
		
		int[,] mark = new int[this.width, this.height];
		Queue<Step> queue = new Queue <Step>();
		queue.Enqueue(new Step(center[0], center[1], -1));
		int side = character.side;
		int dist = (int) System.Math.Floor((double) attack.range.GetLength(0) / 2);
		List<Character> target = new List<Character>();
		
		if(attack.type == 3){
			List<Character[]> targetSet = new List<Character[]>();
			attack.mapRange.ForEach(delegate(int[,] mapRange){
				Character[] characters = this.getTarget(character, new Attack(){range = mapRange, type=2});
				if(characters.Length > 0)
					targetSet.Add (characters);
			});
			
			if(targetSet.Count > 0){
				return targetSet[Random.Range(0, targetSet.Count)];
			}
		}else{
			while(queue.Count > 0){
				Step p = queue.Dequeue();
				if (this.isOverBg(p.X, p.Y) || this.isOverRange(p, center, attackArea, dist) || mark[p.X, p.Y] != 0) continue;
				
				if(this.withinRange(p, center, attackArea, dist) && map[p.X, p.Y].searchTarget(character, searchTarget)){
					if(attack.type == 1 && splash == null)		//單體攻擊
					{
						return new Character[] {map[p.X, p.Y].getChar()};
					}
					else if(attack.type == 1 && attack.splash != null)	//濺射攻擊
					{
						return this.getTarget(character, new Attack(){range = attack.splash, type=2}, new int[2]{p.X, p.Y});
					}
					else if(attack.type == 2)	//全體攻擊
					{
						target.Add(map[p.X, p.Y].getChar());
					}
				}
				mark[p.X, p.Y] = 99;
				
				if(side == 1){
					queue.Enqueue(new Step(p.X - 1, p.Y, 0));
					queue.Enqueue(new Step(p.X + 1, p.Y, 0));
					queue.Enqueue(new Step(p.X, p.Y - 1, 0));
					queue.Enqueue(new Step(p.X, p.Y + 1, 0));
				}else{
					queue.Enqueue(new Step(p.X + 1, p.Y, 0));
					queue.Enqueue(new Step(p.X - 1, p.Y, 0));
					queue.Enqueue(new Step(p.X, p.Y - 1, 0));
					queue.Enqueue(new Step(p.X, p.Y + 1, 0));
					
				}
			}
		}
		return target.ToArray();
	}
	
	//移動路徑演算法
	public Step getMovePath(Character character){
		int[] pos = character.getPos();
		int startX = pos[0];
		int startY = pos[1];
		int[,] mark = new int[this.width, this.height];
		Queue<Step> queue = new Queue <Step>();
		queue.Enqueue(new Step(startX, startY, -1));
		List<Step> footprint = new List<Step>();
		int side = character.side;
		bool hasEnemy = false;
		int i_step = -1;
		
		//尋找同一列的敵人
		if(side == 1){
			for(int i = 1; i < this.width; i++){
				if(startX + i >= this.width && startX - i < 0)
					break;
				
				if((startX + i < this.width && this.map[startX + i, startY].isEnemy(character)) || 
				   (startX - i >= 0 && this.map[startX - i, startY].isEnemy(character))){
					hasEnemy = true;
					break;
				}
			}
		}else{
			for(int i = 1; i < this.width; i++){
				if(startX + i >= this.width && startX - i < 0)
					break;
				
				if((startX - i >= 0 && this.map[startX - i, startY].isEnemy(character)) || 
				   (startX + i < this.width && this.map[startX + i, startY].isEnemy(character))){
					hasEnemy = true;
					break;
				}
			}
		}
		
		//可攻擊位置計算
		bool[,] attackPosition = this.getAttackPosition(character);
		if(attackPosition[startX, startY] == true)	//如果現在的位置就可以打人就停止
			return null;
		
		while(queue.Count > 0){
			Step p = queue.Dequeue();
			
			//如果超出範圍，或是已經計算過，或是不在起點又不可移動的時候就跳過換下一個
			if (this.isOverBg(p.X, p.Y) || mark[p.X, p.Y] != 0 || 
			    (p.X != startX || p.Y != startY) && !this.map[p.X, p.Y].GetComponent<Ground>().isMovable()) 
				continue;
			
			mark[p.X, p.Y] = 99;
			int index = footprint.Count;
			footprint.Add(p);
			
			if (attackPosition[p.X, p.Y] == true){
				i_step = index;
				break;
			}
			
			if(hasEnemy){
				if(side == 1){
					queue.Enqueue(new Step(p.X + 1, p.Y, index));
					queue.Enqueue(new Step(p.X, p.Y - 1, index));
					queue.Enqueue(new Step(p.X, p.Y + 1, index));
					queue.Enqueue(new Step(p.X - 1, p.Y, index));
				}else{
					queue.Enqueue(new Step(p.X - 1, p.Y, index));
					queue.Enqueue(new Step(p.X, p.Y - 1, index));
					queue.Enqueue(new Step(p.X, p.Y + 1, index));
					queue.Enqueue(new Step(p.X + 1, p.Y, index));
				}
			}else{
				if(side == 1){
					queue.Enqueue(new Step(p.X, p.Y - 1, index));
					queue.Enqueue(new Step(p.X, p.Y + 1, index));
					queue.Enqueue(new Step(p.X + 1, p.Y, index));
					queue.Enqueue(new Step(p.X - 1, p.Y, index));
				}else{
					queue.Enqueue(new Step(p.X, p.Y - 1, index));
					queue.Enqueue(new Step(p.X, p.Y + 1, index));
					queue.Enqueue(new Step(p.X - 1, p.Y, index));
					queue.Enqueue(new Step(p.X + 1, p.Y, index));
				}
			}
			
		}
		
		if (i_step > -1){
			Stack <Step> moveStack = new Stack <Step>();
			Step lastStep = footprint[i_step];
			do{
				mark[lastStep.X, lastStep.Y] = 1;
				moveStack.Push(lastStep);
				lastStep = footprint[lastStep.S];
			}while(lastStep.S  != -1);
			return moveStack.Pop();
		}
		return null;
	}
	
	//取得可以攻擊的位置
	public bool[,] getAttackPosition(Character character){
		bool[,] attackPos = new bool[this.width, this.height];
		int side = character.side;
		Character[] enemyTeam;
		
		if (side == 1) {
			enemyTeam = this.defenderTeam;
		} else {
			enemyTeam = this.offensiveTeam;
		}
		
		foreach (Character enemy in enemyTeam) {
			if (enemy) {
				if (enemy.dead)
					continue;
				int[] pos = enemy.getPos ();
				int range = character.attackMode.range.GetLength (0);
				int dist = (int)System.Math.Floor ((double)range / 2);
				
				for (int i=0; i < range; i++) {
					for (int j=0; j < range; j++) {
						int x = pos [0] + (i - dist);
						int y = pos [1] + (j - dist);
						if (character.attackMode.range [i, j] == 0 || this.isOverBg(x, y))
							continue;
						attackPos[x, y] = true;
					}
				}
			}
		}
		
		return attackPos;
	}
	
	public bool isOverRange(Step step, int[] center, int[,] attackRange, int range){
		int x = step.X - (center[0] - range);
		int y = step.Y - (center[1] - range);
		
		if(x > attackRange.GetLength(0) - 1 || y > attackRange.GetLength(1) -1 || x < 0 || y < 0){
			return true;
		}else{
			return false;
		}
	}
	
	public bool withinRange(Step step, int[] center, int[,] attackRange, int range){
		int x = step.X - (center[0] - range);
		int y = step.Y - (center[1] - range);
		return (attackRange[x, y]==1)?true:false;
	}
	
	public bool isOverBg(int x, int y){
		if(x > this.width - 1 || y > height -1 || x < 0 || y < 0){
			return true;
		}else{
			return false;
		}
	}
	
	void Paint(int[,] mark){
		for(int i=0;i<this.height;i++){
			for(int j=0;j<this.width;j++){
				if(mark[j,i] == 99)
					this.map[j,i].transform.GetComponent<SpriteRenderer>().sprite = Resources.Load<Sprite> ("Images/Background/color6");
				else if(mark[j,i] == 1)
					this.map[j,i].transform.GetComponent<SpriteRenderer>().sprite = Resources.Load<Sprite> ("Images/Background/color3");
				else
					this.map[j,i].transform.GetComponent<SpriteRenderer>().sprite = null;
			}
		}
	}
	
	public void addMessage(string key, Dictionary<string, string> data){
		string msg = "";
		switch (key) {
		case "battleStart":
			msg = string.Format ("{0} 在 X:{1} Y:{2} 出現", data ["title"], data ["x"], data ["y"]);
			break;
			
		case "status":
			msg = string.Format("{0} {1}", data ["title"], data ["status"]);
			break;
			
		case "endStep":
			msg = string.Format("{0} 身上的 {1} 消失", data ["targetTitle"], data ["title"]);
			break;
			
		case "damage":
			msg = string.Format("{0} 對 {1} 造成了 {2} 傷害", data ["title"], data ["targetTitle"], data["damage"]);
			break;
			
			/*case "move":
			
			msg = "{$data['title']} 移動到 X:{$data['x']} Y:{$data['y']}";
			break;
			

		case "heal":
			msg = "{$data['title']} 對 {$data['targetTitle']} 恢復 {$data['heal']} 生命";
			break;*/
			
		case "attack":
			if (data ["action"] == "2")
				msg = string.Format ("{0} 對 {1} 施放 「{2}」", data ["attkerTitle"], data ["targetTitle"], data ["title"]);
			else
				msg = string.Format ("{0} 對 {1} 攻擊", data ["attkerTitle"], data ["targetTitle"]);
			
			if (data ["isDodge"] == "true")
				msg += " 未命中";
			else if (data.ContainsKey ("heal") && data ["heal"] != null)
				msg += string.Format (" 恢復 {0} 生命", data ["heal"]);
			else if (data.ContainsKey ("damage") && data ["damage"] != null) {
				msg += string.Format (" 造成 {0} ", data ["damage"]);
				if (data ["prop"] == "2")
					msg += " 法術";
				msg += "傷害";
			}
			
			if(data["debuff"].Length > 0)
				msg += string.Format (" 並造成了 「{0})」", data["debuff"]);
			if(data["buff"].Length > 0)
				msg += string.Format ("  獲得了 「{0})」", data["buff"]);
			
			if (data ["isCrit"] == "true")
				msg += " --- 致命一擊";
			
			break;
			
		case "dead":
			msg = string.Format ("{0} 死亡", data ["title"]);
			break;
		}
		
		print (msg);
	}
}

public class Step
{
	public int X, Y, S;
	
	public Step(int x, int y, int s)
	{
		this.X = x;
		this.Y = y;
		this.S = s;
	}
}