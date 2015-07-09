using UnityEngine;
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
	public int moveCounter = 1;
	public int roundNumber = 0;
	public Character[] offensiveTeam = new Character[5];
	public Character[] defenderTeam = new Character[5];
	int[,] offensivePosition = new int[,] {{1,2},{0,1},{0,2}};
	int[,] defenderPosition = new int[,] {{8,2},{9,1},{9,3}};
	public float itemSize = 1.25f;
	public float scale;
	private bool end = false;

	public int[] offensiveId = new int[5];
	public int[] defenderId = new int[5];
	public int[] offensiveLv = new int[5] {30,30,30,30,30};
	public int[] defenderLv = new int[5] {30,30,30,30,30};
	public int[] offensiveArmy = new int[5]{1,1,1,1,1};
	public int[] defenderArmy = new int[5]{1,1,1,1,1};

	public Ground[,] map;
	private bool someoneAttack = false;
	
	void Awake(){
		Instance = this;
	}


	void Start () {
		this.scale = (float)Screen.width/screenWidth;
//		this.scale = new Vector2((float)Screen.width/screenWidth, (float)Screen.height/screenHeight);
//		GUIUtility.ScaleAroundPivot(this.scale,Vector2.zero);
//		print (scale);

		generateBoard ();
		setOffensive ();
		setDefender ();
		StartCoroutine("nextRound");
	}

	//產生空的盤面
	void generateBoard (){
		this.map = new Ground[this.width, this.height];
		// CleanBoard();
		for(int i=0;i<this.height;i++){
			for(int j=0;j<this.width;j++){
				float y = i * itemSize + 0.1f * i + 1.0f;
				float x = j * itemSize + 0.1f * j + 1.0f;
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
		
	IEnumerator nextRound(){
		if (this.someoneAttack)
			yield return new WaitForSeconds (1.5f);
		else
			yield return 0;
		this.startStep ();
//		this.ultimateStep ();
		this.attackStep ();
		this.moveStep();
	}

	public void checkNextRound(){
		foreach(Character character in offensiveTeam){
			if(character && character.isOver == false){
				return;
			}
		}

		foreach(Character character in defenderTeam){
			if(character && character.isOver == false){
				return;
			}
		}

		this.endStep();
        //行動完成後二秒，再去執行下一回合
		StartCoroutine ("nextRound");
	}

	public void startStep(){
		this.roundNumber++;
		this.roundCounter.transform.GetComponent<UnityEngine.UI.Text> ().text = "Round " + this.roundNumber.ToString();
		this.moveCounter = 1;
		this.someoneAttack = false;
		//		print ("Round" + this.roundNumber.ToString());
		
		//回合開始時，所有角色進行處理狀態debuff buff
		foreach(Character character in offensiveTeam){
			if(character && !character.dead){
				character.startStep();
			}
		}
		
		foreach(Character character in defenderTeam){
			if(character && !character.dead){
				character.startStep();
			}
		}
	}

	public void ultimateStep(){
		//回合開始時，所有角色進行處理狀態debuff buff
		foreach(Character character in offensiveTeam){
			if(character && !character.dead){
				character.startStep();
			}
		}
		
		foreach(Character character in defenderTeam){
			if(character && !character.dead){
				character.startStep();
			}
		}
	}

	void attackStep(){
		//回合開始時，所有角色進行處理狀態debuff buff
		foreach(Character character in offensiveTeam){
			if(character && !character.dead){
				this.someoneAttack = character.attackStep();
			}
		}
		
		foreach(Character character in defenderTeam){
			if(character && !character.dead){
				this.someoneAttack = character.attackStep();
			}
		}
	}

	void moveStep(){
		bool om = false, dm = false;
		do{
			om = offensiveMove();
			dm = defenderMove();
			moveCounter++;
		}while(om || dm);
	}

	private void endStep(){
		bool offensiveTeamGameOver = true;
		bool defenderTeamGameOver = true;

		//角色死亡處理
		foreach(Character character in offensiveTeam){
			//若角色沒死亡，而且進行結束階段後還活著
			if(character && !character.dead && !character.endStep()){
				offensiveTeamGameOver =false;
			}
		}

		foreach(Character character in defenderTeam){
			if(character && !character.dead && !character.endStep()){
				defenderTeamGameOver=false;
			}
		}

		if (offensiveTeamGameOver || defenderTeamGameOver) {
			print ("game over");
			this.end = true;
		}
		
		//若有人死亡，就做結束遊戲的計算
		/*if(offensiveTeamGameOver && defenderTeamGameOver)
			return "both";
		else if(offensiveTeamGameOver)
			return "defender";
		else if(defenderTeamGameOver)
			return "offensive";
		else
			return false;*/
	}

	bool offensiveMove(){
		bool flag = false;
		foreach(Character character in offensiveTeam){
			if(character){
				if(character.dead || character.isAttacked())	continue;
				//若角色的移動力大於等於步數，就再進行移動
				if(character.movementRange >= moveCounter){
					Step moveTo = getMovePath(character);
					if(moveTo != null){
						this.map[character.x, character.y].clearChar();
						this.map[moveTo.X, moveTo.Y].setChar(character);
						character.moveTo(moveTo);
						flag = true;
					}
				}
			}
		}
		return flag;
	}

	bool defenderMove(){
		bool flag = false;
		foreach(Character character in defenderTeam){
			if(character){
				if(character.dead || character.isAttacked())	continue;
				//若角色的移動力大於等於步數，就再進行移動
				if(character.movementRange >= moveCounter){
					Step moveTo = getMovePath(character);
					if(moveTo != null){
						this.map[character.x, character.y].clearChar();
						this.map[moveTo.X, moveTo.Y].setChar(character);
						character.moveTo(moveTo);
						flag = true;
					}else{
						character.isMove = true;
					}
				}
			}
		}
		return flag;
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

				if((startX + i < this.width && this.map[startX + i, startY].GetComponent<Ground>().isEnemy(character)) || 
				  (startX - i >= 0 && this.map[startX - i, startY].GetComponent<Ground>().isEnemy(character))){
					hasEnemy = true;
					break;
				}
			}
		}else{
			for(int i = 1; i < this.width; i++){
				if(startX + i >= this.width && startX - i < 0)
					break;
				
				if((startX - i >= 0 && this.map[startX - i, startY].GetComponent<Ground>().isEnemy(character)) || 
				   (startX + i < this.width && this.map[startX + i, startY].GetComponent<Ground>().isEnemy(character))){
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

//		print (msg);
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