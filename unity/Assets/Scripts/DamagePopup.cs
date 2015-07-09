using UnityEngine;
using System.Collections;

public class DamagePopup : MonoBehaviour {
	public popupText damage;

	public float freeTime=2.0F;
//	public Transform damageText;
	// Use this for initialization
	void Start () {
		StartCoroutine("disappear");
		transform.GetComponent<UnityEngine.UI.Text>().text = this.damage.value.ToString();
	}
	
	// Update is called once per frame
	void Update () {
		transform.Translate(Vector3.up * 50.0F * Time.deltaTime);
		Color color = transform.GetComponent<UnityEngine.UI.Text> ().color;
		color.a -= 0.005f;
		transform.GetComponent<UnityEngine.UI.Text> ().color = color;
	}

	IEnumerator disappear(){
		yield return new WaitForSeconds(freeTime);
		Destroy(this.gameObject);
	}
}
