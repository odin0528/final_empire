using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Character_2 : Character {

	public void Start(){
		this.ultimate = new Attack (){
			title = "大地噴出劍",
			type = 1,
			prop = 1,
			rate = 1.1f,
			range = new int[3,3] {
						{0,1,0},
						{1,1,1},
						{0,1,0}
					},
			splash = new int[3,3] {
				{0,1,0},
				{1,1,1},
				{0,1,0}
			},
			debuff = 1
		};

		this.skill1 = new Attack (){
			title = "擊暈",
			type = 1,
			prop = 1,
			rate = 1.0f,
			range = new int[3,3] {
				{0,1,0},
				{1,1,1},
				{0,1,0}
			},
			debuff = 1
		};
	}
}