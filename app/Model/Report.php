<?php

namespace Fourum\Model;

use Carbon\Carbon;
use Fourum\Reporting\ReportableInterface;
use Fourum\Reporting\ReportInterface;
use Fourum\User\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * @property Carbon created_at
 * @property bool read
 * @property string message
 * @property int id
 * @property string foreign_key
 * @property int foreign_id
 */
class Report extends Model implements ReportInterface
{
    /**
     * @var string
     */
    protected $table = 'reports';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return ReportableInterface
     */
    public function getReportable()
    {
        $repositoryFactory = App::make('Fourum\Repository\RepositoryFactory');

        $repository = $repositoryFactory->build($this->foreign_key);

        return $repository->get($this->foreign_id);
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->belongsTo('Fourum\Model\User', null, null, 'user')->first();
    }

    public function markAsRead()
    {
        $this->read = true;
    }
}