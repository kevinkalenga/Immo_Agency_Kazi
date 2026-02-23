<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
     protected $guarded = [];

      /**
     * RELATION : Property → PropertyType
     * ---------------------------------
     * Une propriété appartient à UN SEUL type.
     * 
     * Exemple :
     * - Apartment
     * - Villa
     * - Office
     *
     * Structure DB :
     * properties.ptype_id → property_types.id
     *
     * Utilisation :
     * $property->type
     * $property->type->type_name
     */
     
     
     public function type() {
          return $this->belongsTo(PropertyType::class, 'ptype_id', 'id');
     }

      /**
     * RELATION : Property → User (Agent)
     * ----------------------------------
     * Une propriété peut être assignée à UN agent.
     * 
     * Cas possibles :
     * - agent_id = NULL → propriété créée par Admin
     * - agent_id = X    → propriété gérée par un agent
     *
     * Structure DB :
     * properties.agent_id → users.id
     *
     * Utilisation :
     * $property->user
     * $property->user->name
     */

     public function user(){
        return $this->belongsTo(User::class,'agent_id','id');
     }

     /**
     * RELATION THÉORIQUE : Property ↔ Amenities (Many-to-Many)
     * ------------------------------------------------------------
     * CETTE RELATION N'EST PAS UTILISÉE DANS TON PROJET ACTUEL.
     *
     * Laravel s'attendrait à :
     * - une table pivot : amenitie_property
     * - colonnes : property_id | amenitie_id
     *
     * Utilisation normale :
     * $property->amenities
     * $property->amenities()->attach([1,2,3]);
     *
     * MAIS dans TON projet :
     * - Les amenities sont stockées en CSV
     *   dans properties.amenities_id
     * - Il n'y a PAS de table pivot
     *
     * Cette relation ne fonctionnera PAS
     * tant que tu n'as pas créé la table pivot.
     *
     * À garder seulement si tu prévois
     * une refonte future propre.
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenitie::class);
    }
}
