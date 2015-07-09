using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Attack {
	public int action = 1;		//行為1 普攻 2技能
	public float rate = 1.0f;	//倍率
	public string title;
	public int type = 1;
	//1:單體  
	//2:範圍(有splash的時候，type還是帶1就好)
	//3:方向性攻擊
	public int[,] range	=	new int[3,3] {
		{0,1,0},
		{1,1,1},
		{0,1,0}
	};
	public List<int[,]> mapRange = new List<int[,]>();
	public int[,] splash;
	public int prop = 1;		//1 物理傷害 2魔法傷害
	public string target;		//ally 同隊
	public int buff;
	public int debuff;

	public void setRange(int[,] newRange){
		range = newRange;
	}
}
