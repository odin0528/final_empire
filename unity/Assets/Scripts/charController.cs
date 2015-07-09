using UnityEngine;
using System.Collections;

public class charController : MonoBehaviour {
	public Character character;
	public void onClick ()
	{
		if(character.en == 100)
			character.isCastUltimate = true;
	}
}
