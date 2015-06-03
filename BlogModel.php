<?php

class BlogModel
{
	public function login($username, $password)
	{
		$param = array($username, $password . "t&#ssdf54gh");
		return Db::dotaz('SELECT id
                FROM user
                WHERE username=? AND password=SHA1(?)
        ', $param);
	}
	public function registrace($username,  $password, $email)
	{
		$param = array($username, $password . "t&#ssdf54gh", $email);
		//overovaciEmail($email,$username);
		return Db::dotaz('INSERT INTO user (username, password, email) VALUES (?,SHA1(?),?)', $param);
	}

	private function overovaciEmail($email, $username)
	{
		mail($email, "Registrace na blog", "Uživatel " . $username. " byl úspěšně zaregistrován.");
	}

	public function pridatClanek($title, $author, $text, $perex)
	{
		$param = array($title, $text, $author, $perex);
		return Db::dotaz('INSERT INTO post (title, text, author, perex) VALUES (?,?,?,?)', $param);
	}
	public function isAdmin($username, $password)
	{
		$param = array($username, $password . "t&#ssdf54gh");
		return Db::dotaz('SELECT id
                FROM user
                WHERE username=? AND password=SHA1(?) AND administrator=1
        ', $param);
	}
	public function vybratClanek($id)
	{
		$param = array($id);
		return Db::dotazVsechny('SELECT * FROM post WHERE id=?', $param);
	}
	public function vybratKomentare($id)
	{
		$param = array($id);
		return Db::dotazVsechny('SELECT * FROM comment WHERE id_post=?', $param);
	}
	public function pridatKoment($text, $name, $id_post)
	{
		$param = array($id_post, $name, $text);
		return Db::dotaz('INSERT INTO comment (id_post, name, text) VALUES (?,?,?)', $param);
	}	
	public function odebratKoment($id)
	{
		$param = array($id);
		return Db::dotaz('DELETE FROM comment WHERE id=?', $param);
	}
	public function odebratPost($id)
	{
		$param = array($id);
		$odebratKomenty = Db::dotazVsechny('DELETE FROM comment WHERE id_post=?', $param);
		return Db::dotaz('DELETE FROM post WHERE id=?', $param);
	}
	public function upravitPost($id, $title, $text, $perex)
	{
		$param = array($title, $text, $perex, $id);
		return Db::dotaz('UPDATE post SET title=?, `text`=?, perex=? WHERE id=?', $param);
	}
}