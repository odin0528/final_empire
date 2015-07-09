using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Debuff_2 : Debuff {
	override public void effect(){

		int damage = this.caster.mp;
		damage = this.caster.calcDamage(damage, this.character, 2);
		this.character.dot(new popupText(){type=1, value=damage}, this.caster);

		Dictionary<string, string> data = new Dictionary<string, string>();
		data.Add("prop", "2");
		data.Add("targetId", this.character.side.ToString() + '-' + this.character.charId.ToString());
		data.Add("targetTitle", this.character.side.ToString() + " - " + this.character.title + this.character.name);
		data.Add("title", this.title);
		data.Add("damage", this.character._hurt.ToString());
		
		BG.addMessage("damage", data);
	}
}
