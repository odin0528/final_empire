using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Army : MonoBehaviour{
	public string title;
	public float hpRate = 1.0f;
	public float atkRate = 1.0f;
	public float defRate = 1.0f;
	public float resRate = 1.0f;
	public int movementRange = 1;
	/*
	public $attackRange = array(
								array(0,0,1,0,0),
								array(0,0,1,0,0),
								array(1,1,1,1,1),
								array(0,0,1,0,0),
								array(0,0,1,0,0)
							);
	protected $attackRange = array(
								array(0,0,0,1,0,0,0),
								array(0,0,1,1,1,0,0),
								array(0,1,1,1,1,1,0),
								array(1,1,1,1,1,1,1),
								array(0,1,1,1,1,1,0),
								array(0,0,1,1,1,0,0),
								array(0,0,0,1,0,0,0),
							);*/
	void Start(){}

	public void init(){
		transform.name = title;
		Character character = transform.GetComponentInParent<Character>();
		character.army = title;
		character.movementRange = movementRange;
		character.hpRate = hpRate;
		character.defRate = defRate;
		character.resRate = resRate;
		character.atkRate = atkRate;
	}
}