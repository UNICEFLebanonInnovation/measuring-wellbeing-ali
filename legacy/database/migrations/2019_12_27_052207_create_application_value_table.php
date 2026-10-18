<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('application_value')) {
            Schema::create('application_value', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('application_id');
                $table->enum('type', ["pre_test","post_test"])->nullable();
                $table->string('category',50)->nullable();
                $table->string('child_code',50)->nullable();
                $table->string('gouvarnate',50)->nullable();
                $table->string('caza',50)->nullable();
                $table->string('agency_name',50)->nullable();
                $table->string('form')->nullable();
                $table->string('donor_name',50)->nullable();
                $table->string('interview_date',50)->nullable();
                $table->string('interviewers_name',50)->nullable();
                $table->string('age',50)->nullable();
                $table->string('gender',50)->nullable();
                $table->string('nationality',50)->nullable();
                $table->string('area',50)->nullable();
                $table->string('gateway_type',50)->nullable();
                $table->string('p_code',50)->nullable();
                $table->string('latitude',50)->nullable();
                $table->string('longitude',50)->nullable();
                $table->string('altitude',50)->nullable();
                $table->string('accuracy',50)->nullable();
                $table->string('may_i_start_now',50)->nullable();
                $table->string('considerate_of_other_peoples_feelings',50)->nullable();
                $table->string('restless_overactive_cannot_stay_still_for_long',50)->nullable();
                $table->string('often_complains_of_headaches_stomach_aches_or_sickness',50)->nullable();
                $table->string('shares_readily_with_other_children_for_example_toys',50)->nullable();
                $table->string('often_loses_temper',50)->nullable();
                $table->string('rather_solitary_prefers_to_play_alone',50)->nullable();
                $table->string('generally_well_behaved_usually_does_what_adults_request',50)->nullable();
                $table->string('many_worries_or_often_seems_worried',50)->nullable();
                $table->string('helpful_if_someone_is_hurt_upset_or_feeling_ill',50)->nullable();
                $table->string('constantly_fidgeting_or_squirming',50)->nullable();
                $table->string('has_at_least_one_good_friend',50)->nullable();
                $table->string('often_fights_with_other_hildren_or_bullies_them',50)->nullable();
                $table->string('often_unhappy_depressed_or_tearful',50)->nullable();
                $table->string('generally_liked_by_other_children',50)->nullable();
                $table->string('easily_distracted_concentration_wanders',50)->nullable();
                $table->string('nervous_or_clingy_in_new_situations_easily_loses_confidence',50)->nullable();
                $table->string('kind_to_younger_children',50)->nullable();
                $table->string('often_lies_or_cheats',50)->nullable();
                $table->string('picked_on_or_bullied_by_other_children',50)->nullable();
                $table->string('often_offers_to_help_others',50)->nullable();
                $table->string('thinks_things_out_before_acting',50)->nullable();
                $table->string('steals_from_home_school_or_elsewhere',50)->nullable();
                $table->string('gets_along_better_with_adults_than_with_other_children',50)->nullable();
                $table->string('many_fears_easily_scared',50)->nullable();
                $table->string('good_attention_span_sees_chores_or_homework_through_to_the_end',255)->nullable();
                $table->string('number_of_hours_that_the_child_attended',255)->nullable();
                $table->string('total_number_of_hours_in_your_program',50)->nullable();
                $table->string('dropout_reason',50)->nullable();
                $table->string('justify_the_dropout_reason',50)->nullable();
                $table->text('do_the_child_receive_any_other_child_protection_services')->nullable();
                $table->text('comment')->nullable();
                $table->string('score',255)->nullable();
                $table->timestamps();
            });
        }else{
            Schema::table('application_value',function(Blueprint $table){
                $table->string('score',255)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_value');
    }
}
