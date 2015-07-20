using UnityEngine;
using System.Collections;

public class Army_3 : Army {
	protected override void setAttack(){
		Attack newAttack = new Attack (){
			range = new int[5,5]{
				{0,0,1,0,0},
				{0,0,0,0,0},
				{1,0,1,0,1},
				{0,0,0,0,0},
				{0,0,1,0,0}
			}
		};
		
		Character character = transform.GetComponentInParent<Character>();
		character.attackMode = newAttack;
	}
}
