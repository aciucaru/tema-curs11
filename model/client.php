<?php
class Client
{
    private int $id = -1;
    public string $nume = "";
    public string $username = "";
    public string $email = "";
    public string $hashParola = "";
    public string $comenzi = "";

    public function __construct(
                                    int $id,
                                    string $nume = "",
                                    string $username = "",
                                    string $email = "",
                                    string $hashParola = "",
                                    string $comenzi = ""
                                )
    {
        $this->id = $id;
        if(isset($nume))
            $this->nume = $nume;
        if(isset($username))
            $this->username = $username;
        if(isset($email))
            $this->email = $email;
        if(isset($hashParola))
            $this->hashParola = $hashParola;
        if(isset($username))
            $this->comenzi = $comenzi;
    }

    public function getId() { return $this->id; }
}
?>