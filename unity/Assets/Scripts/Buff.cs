using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Buff : MonoBehaviour {
	private BattleGround BG;
	public int id;
	public Character character;		//在某角色身上
	public Character caster;		//施於此buff的角色
	public string title;
	public string type = "status";
	public int duration = 1;
	public int value;
	public bool isEnable = false;

	void Awake () {
		BG = BattleGround.Instance;
	}
	
	public Buff init(Character character, Character caster){
		this.character = character;
		this.caster = caster;
		return this;
	}
	
	virtual public void effect(){}
	virtual public void effectInstantly(){
		this.effect ();
		this.duration--;
	}
	public bool nextRound(){
		bool done = false;
		this.isEnable = true;
		if(this.duration == 0)
			done = this.finish();
		this.duration--;
		return done;
	}
	
	public bool finish(){
		Dictionary<string, string> data = new Dictionary<string, string>();
		data.Add("title", this.title);
		data.Add("targetId", this.character.side.ToString() + "-" + this.character.charId);
		data.Add("targetTitle", this.character.side.ToString() + " - " + this.character.title + this.character.name);
		BG.addMessage("endStep", data);

		Destroy (this.gameObject);
		return true;
	}

	void setValue(int value){
		this.value = value;
	}

	void setDuration(int value){
		this.duration = value;
	}
}
