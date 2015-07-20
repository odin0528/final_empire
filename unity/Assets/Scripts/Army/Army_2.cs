using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Army_2 : Army {
	protected override void setAttack(){
		Attack newAttack = new Attack ();
		newAttack.setRange (new int[3,3] {
			{0,1,0},
			{1,1,1},
			{0,1,0}}
		);

		Character character = transform.GetComponentInParent<Character>();
		character.attackMode = newAttack;
	}
}
