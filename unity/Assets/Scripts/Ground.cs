using UnityEngine;
using System.Collections;

public class Ground : MonoBehaviour {
	private bool movable;
	private int side = 0;
	private Character character;

	public void setChar(Character character){
		this.side = character.side;
		this.character = character;
	}
	
	public Character getChar(){
		return this.character;
	}

	public void clearChar(){
		this.side = 0;
		this.character = null;
	}
	
	public bool isMovable(){
		return this.side==0?true:false;
	}

	public bool searchTarget(Character character, string target){
		if (target == "ally")
			return this.isAlly (character);
		else
			return this.isEnemy (character);
	}

	public bool isEnemy(Character character){
		return (this.side != 0 && character.side != this.side);
	}
	
	public bool isAlly(Character character){
		return (this.side != 0 && character.side == this.side);
	}
}
