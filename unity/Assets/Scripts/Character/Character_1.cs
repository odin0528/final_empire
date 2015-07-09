using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Character_1 : Character {
	public void Start(){
		this.ultimate = new Attack (){
			title = "背刺",
			type = 1,
			prop = 1,
			rate = 2.5f,
			range = new int[3,3] {
						{1,1,1},
						{1,1,1},
						{1,1,1}
					}
		};

		this.skill1 = new Attack (){
			title = "飛鏢",
			type = 1,
			prop = 1,
			rate = 1.5f,
			range = new int[5,5] {
				{0,0,1,0,0},
				{0,1,1,1,0},
				{1,1,1,1,1},
				{0,1,1,1,0},
				{0,0,1,0,0}
			}
		};
	}

	override public void appear(){}	//角色出現的時候，用來設定被動技能的效果

	override public bool castUltimate(){
		Character[] target = this.getTarget(this.ultimate);
		if(target != null && target.Length > 0){
			this.damage(target, this.ultimate);
			return true;
		}
		return false;
	}

	override public bool caseSkill1(){

		Character[] target = this.getTarget(this.skill1);
		if(target != null && target.Length > 0){
			_Anim.SetTrigger ("castUltimate");
			this.damage(target, this.skill1);
			return true;
		}
		return false;
	}

	override public bool caseSkill2(){
		Character[] target = this.getTarget(this.skill2);
		if(target != null && target.Length > 0){
			this.damage(target, this.skill2);
			return true;
		}
		return false;
	}

	override public bool caseSkill3(){
		Character[] target = this.getTarget(this.skill3);
		if(target != null && target.Length > 0){
			this.damage(target, this.skill3);
			return true;
		}
		return false;
	}

	override public bool caseSkill4(){
		Character[] target = this.getTarget(this.skill4);
		if(target != null && target.Length > 0){
			this.damage(target, this.skill4);
			return true;
		}
		return false;
	}
}