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
}