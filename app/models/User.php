<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $softDelete = true;

	/* Events */
	public static function boot() {
		parent::boot();

		self::saving(function($user) {
			$user->fulltext();
		});
	}

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}
	
	/* Mass assignment */
	protected $fillable = array('role_id','subscriber_id','email','password','first_name','last_name','token_id');
	
	/* Relationships */
	public function role() {
		return $this->belongsTo('Role');
	}
	
	public function subscriber() {
		return $this->belongsTo('Subscriber');
	}
	
	public function client() {
		return $this->hasOne('Client');
	}
	
	public function emails() {
		return $this->morphMany('Email','emailable');
	}
	
	public function addresses() {
		return $this->morphMany('Address');
	}

	public function token() {
		return $this->belongsTo('Token');
	}

	public function permissions() {
		return $this->morphMany('Permission','agent');
	}
	
	/* Mutators */
	public function setPasswordAttribute($value) {
		if(empty($value)) {return false;}
		$this->attributes['password'] = Hash::make($value);
	}
	
	/* Mail */
	public function sendEmail($subject,$view,$data) {

		$primaryContactEmail = Settingname::where('name','primary contact email')
			->first()
			->subscriberValue;

		$email = [
			'subject'=>$subject,
			'fromEmail'=>$primaryContactEmail ? $primaryContactEmail : 'support@protocolapp.com',
			'fromName'=>$this->subscriber ? $this->subscriber->name : 'Protocol',
			'to'=>$this->email
		];

		Mail::queue($view,$data,function($message) use ($email) {
			$message
				->from($email['fromEmail'],$email['fromName'])
				->to($email['to'])
				->subject($email['subject']);
		});

		Email::create([
			'emailable_id'=>$this->id,
			'emailable_type'=>'User',
			'message'=>is_array($view) ? array_shift($view) : $view
		]);

	}

	public function name() {
		return $this->first_name.' '.$this->last_name;
	}

	public function home() {
		switch($this->role->name) {
			case 'client':
				return "clients/{$this->client->id}";
				break;
			case 'protocol':
				return "clients";
				break;
		}
	}

	public function has($actions) {
		return Rbac::check($this)->has($actions);
	}

	public function requires($actions) {
		return Rbac::insist($this)->has($actions);
	}

	/* Fulltext */
	public function fulltext() {
		$values = array(
			$this->first_name,
			$this->last_name,
			$this->email,
			$this->role->name
		);

		$this->fulltext = implode(' ',$values);
	}

	public function is($id) {
		return $this->id == $id;
	}
}