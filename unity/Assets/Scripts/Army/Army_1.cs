using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Army_1 : Army {
	protected override void setAttack(){
		Attack newAttack = new Attack ();
		newAttack.setRange (new int[3,3] {
			{1,1,1},
			{1,1,1},
			{1,1,1}}
		);

		Character character = transform.GetComponentInParent<Character>();
		character.attackMode = newAttack;
	}
}
