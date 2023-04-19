<?php
class Produs
{
    private int $id;
    public string $denumire = "";
    public float $pret = 0.0;
    public int $bucatiStoc = 0;

    public function __construct(
                                    int $id,
                                    string $denumire,
                                    float $pret,
                                    int $bucatiStoc
                                )
    {
        $this->id = $id;
        if(isset($denumire))
            $this->denumire = $denumire;
        if($pret >= 0.0)
            $this->pret = $pret;
        if($bucatiStoc >= 0)
            $this->bucatiStoc = $bucatiStoc;
    }

    public function getId() { return $this->id; }
}
?>