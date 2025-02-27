<?php


/**
 * Base class that represents a row from the 'cc_playlistcontents' table.
 *
 *
 *
 * @package    propel.generator.airtime.om
 */
abstract class BaseCcPlaylistcontents extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'CcPlaylistcontentsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CcPlaylistcontentsPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the playlist_id field.
     * @var        int
     */
    protected $playlist_id;

    /**
     * The value for the file_id field.
     * @var        int
     */
    protected $file_id;

    /**
     * The value for the block_id field.
     * @var        int
     */
    protected $block_id;

    /**
     * The value for the stream_id field.
     * @var        int
     */
    protected $stream_id;

    /**
     * The value for the tuneurl_id field.
     * @var        int
     */
    protected $tuneurl_id;

    /**
     * The value for the type field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $type;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * The value for the trackoffset field.
     * Note: this column has a database default value of: 0.0
     * @var        double
     */
    protected $trackoffset;

    /**
     * The value for the cliplength field.
     * Note: this column has a database default value of: '00:00:00'
     * @var        string
     */
    protected $cliplength;

    /**
     * The value for the cuein field.
     * Note: this column has a database default value of: '00:00:00'
     * @var        string
     */
    protected $cuein;

    /**
     * The value for the cueout field.
     * Note: this column has a database default value of: '00:00:00'
     * @var        string
     */
    protected $cueout;

    /**
     * The value for the fadein field.
     * Note: this column has a database default value of: '00:00:00'
     * @var        string
     */
    protected $fadein;

    /**
     * The value for the fadeout field.
     * Note: this column has a database default value of: '00:00:00'
     * @var        string
     */
    protected $fadeout;

    /**
     * @var        CcFiles
     */
    protected $aCcFiles;

    /**
     * @var        CcBlock
     */
    protected $aCcBlock;

    /**
     * @var        CcPlaylist
     */
    protected $aCcPlaylist;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    // aggregate_column_relation behavior
    protected $oldCcPlaylist;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->type = 0;
        $this->tuneurl_id = 0;
        $this->trackoffset = 0.0;
        $this->cliplength = '00:00:00';
        $this->cuein = '00:00:00';
        $this->cueout = '00:00:00';
        $this->fadein = '00:00:00';
        $this->fadeout = '00:00:00';
    }

    /**
     * Initializes internal state of BaseCcPlaylistcontents object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getDbId()
    {

        return $this->id;
    }

    /**
     * Get the [playlist_id] column value.
     *
     * @return int
     */
    public function getDbPlaylistId()
    {

        return $this->playlist_id;
    }

    /**
     * Get the [file_id] column value.
     *
     * @return int
     */
    public function getDbFileId()
    {

        return $this->file_id;
    }

    /**
     * Get the [block_id] column value.
     *
     * @return int
     */
    public function getDbBlockId()
    {

        return $this->block_id;
    }

    /**
     * Get the [stream_id] column value.
     *
     * @return int
     */
    public function getDbStreamId()
    {

        return $this->stream_id;
    }

    /**
     * Get the [tuneurl_id] column value.
     *
     * @return int
     */
    public function getDbTuneurlId()
    {

        return $this->tuneurl_id;
    }

    /**
     * Get the [type] column value.
     *
     * @return int
     */
    public function getDbType()
    {

        return $this->type;
    }

    /**
     * Get the [position] column value.
     *
     * @return int
     */
    public function getDbPosition()
    {

        return $this->position;
    }

    /**
     * Get the [trackoffset] column value.
     *
     * @return double
     */
    public function getDbTrackOffset()
    {

        return $this->trackoffset;
    }

    /**
     * Get the [cliplength] column value.
     *
     * @return string
     */
    public function getDbCliplength()
    {

        return $this->cliplength;
    }

    /**
     * Get the [cuein] column value.
     *
     * @return string
     */
    public function getDbCuein()
    {

        return $this->cuein;
    }

    /**
     * Get the [cueout] column value.
     *
     * @return string
     */
    public function getDbCueout()
    {

        return $this->cueout;
    }

    /**
     * Get the [optionally formatted] temporal [fadein] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDbFadein($format = '%X')
    {
        if ($this->fadein === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->fadein);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->fadein, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [fadeout] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDbFadeout($format = '%X')
    {
        if ($this->fadeout === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->fadeout);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->fadeout, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::ID;
        }


        return $this;
    } // setDbId()

    /**
     * Set the value of [playlist_id] column.
     *
     * @param  int $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbPlaylistId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->playlist_id !== $v) {
            $this->playlist_id = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::PLAYLIST_ID;
        }

        if ($this->aCcPlaylist !== null && $this->aCcPlaylist->getDbId() !== $v) {
            $this->aCcPlaylist = null;
        }


        return $this;
    } // setDbPlaylistId()

    /**
     * Set the value of [file_id] column.
     *
     * @param  int $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbFileId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->file_id !== $v) {
            $this->file_id = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::FILE_ID;
        }

        if ($this->aCcFiles !== null && $this->aCcFiles->getDbId() !== $v) {
            $this->aCcFiles = null;
        }


        return $this;
    } // setDbFileId()

    /**
     * Set the value of [block_id] column.
     *
     * @param  int $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbBlockId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->block_id !== $v) {
            $this->block_id = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::BLOCK_ID;
        }

        if ($this->aCcBlock !== null && $this->aCcBlock->getDbId() !== $v) {
            $this->aCcBlock = null;
        }


        return $this;
    } // setDbBlockId()

    /**
     * Set the value of [stream_id] column.
     *
     * @param  int $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbStreamId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->stream_id !== $v) {
            $this->stream_id = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::STREAM_ID;
        }


        return $this;
    } // setDbStreamId()

    /**
     * Set the value of [tuneurl_id] column.
     *
     * @param  int $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbTuneurlId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        // if ($this->tuneurl_id !== $v) {
            $this->tuneurl_id = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::TUNEURL_ID;
        // }


        return $this;
    } // setDbTuneurlId()

    /**
     * Set the value of [type] column.
     *
     * @param  int $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::TYPE;
        }


        return $this;
    } // setDbType()

    /**
     * Set the value of [position] column.
     *
     * @param  int $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbPosition($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::POSITION;
        }


        return $this;
    } // setDbPosition()

    /**
     * Set the value of [trackoffset] column.
     *
     * @param  double $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbTrackOffset($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->trackoffset !== $v) {
            $this->trackoffset = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::TRACKOFFSET;
        }


        return $this;
    } // setDbTrackOffset()

    /**
     * Set the value of [cliplength] column.
     *
     * @param  string $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbCliplength($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cliplength !== $v) {
            $this->cliplength = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::CLIPLENGTH;
        }


        return $this;
    } // setDbCliplength()

    /**
     * Set the value of [cuein] column.
     *
     * @param  string $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbCuein($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cuein !== $v) {
            $this->cuein = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::CUEIN;
        }


        return $this;
    } // setDbCuein()

    /**
     * Set the value of [cueout] column.
     *
     * @param  string $v new value
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbCueout($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cueout !== $v) {
            $this->cueout = $v;
            $this->modifiedColumns[] = CcPlaylistcontentsPeer::CUEOUT;
        }


        return $this;
    } // setDbCueout()

    /**
     * Sets the value of [fadein] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbFadein($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fadein !== null || $dt !== null) {
            $currentDateAsString = ($this->fadein !== null && $tmpDt = new DateTime($this->fadein)) ? $tmpDt->format('H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('H:i:s') : null;
            if ( ($currentDateAsString !== $newDateAsString) // normalized values don't match
                || ($dt->format('H:i:s') === '00:00:00') // or the entered value matches the default
                 ) {
                $this->fadein = $newDateAsString;
                $this->modifiedColumns[] = CcPlaylistcontentsPeer::FADEIN;
            }
        } // if either are not null


        return $this;
    } // setDbFadein()

    /**
     * Sets the value of [fadeout] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return CcPlaylistcontents The current object (for fluent API support)
     */
    public function setDbFadeout($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fadeout !== null || $dt !== null) {
            $currentDateAsString = ($this->fadeout !== null && $tmpDt = new DateTime($this->fadeout)) ? $tmpDt->format('H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('H:i:s') : null;
            if ( ($currentDateAsString !== $newDateAsString) // normalized values don't match
                || ($dt->format('H:i:s') === '00:00:00') // or the entered value matches the default
                 ) {
                $this->fadeout = $newDateAsString;
                $this->modifiedColumns[] = CcPlaylistcontentsPeer::FADEOUT;
            }
        } // if either are not null


        return $this;
    } // setDbFadeout()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->type !== 0) {
                return false;
            }

            if ($this->trackoffset !== 0.0) {
                return false;
            }

            if ($this->cliplength !== '00:00:00') {
                return false;
            }

            if ($this->cuein !== '00:00:00') {
                return false;
            }

            if ($this->cueout !== '00:00:00') {
                return false;
            }

            if ($this->fadein !== '00:00:00') {
                return false;
            }

            if ($this->fadeout !== '00:00:00') {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->playlist_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->file_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->block_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->stream_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->type = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->position = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->trackoffset = ($row[$startcol + 7] !== null) ? (double) $row[$startcol + 7] : null;
            $this->cliplength = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->cuein = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->cueout = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->fadein = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->fadeout = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->tuneurl_id = (array_key_exists($startcol + 13, $row) && $row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
            $this->resetModified(); 

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 14; // 13 = CcPlaylistcontentsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating CcPlaylistcontents object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aCcPlaylist !== null && $this->playlist_id !== $this->aCcPlaylist->getDbId()) {
            $this->aCcPlaylist = null;
        }
        if ($this->aCcFiles !== null && $this->file_id !== $this->aCcFiles->getDbId()) {
            $this->aCcFiles = null;
        }
        if ($this->aCcBlock !== null && $this->block_id !== $this->aCcBlock->getDbId()) {
            $this->aCcBlock = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CcPlaylistcontentsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CcPlaylistcontentsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCcFiles = null;
            $this->aCcBlock = null;
            $this->aCcPlaylist = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CcPlaylistcontentsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CcPlaylistcontentsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CcPlaylistcontentsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                // aggregate_column_relation behavior
                $this->updateRelatedCcPlaylist($con);
                CcPlaylistcontentsPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCcFiles !== null) {
                if ($this->aCcFiles->isModified() || $this->aCcFiles->isNew()) {
                    $affectedRows += $this->aCcFiles->save($con);
                }
                $this->setCcFiles($this->aCcFiles);
            }

            if ($this->aCcBlock !== null) {
                if ($this->aCcBlock->isModified() || $this->aCcBlock->isNew()) {
                    $affectedRows += $this->aCcBlock->save($con);
                }
                $this->setCcBlock($this->aCcBlock);
            }

            if ($this->aCcPlaylist !== null) {
                if ($this->aCcPlaylist->isModified() || $this->aCcPlaylist->isNew()) {
                    $affectedRows += $this->aCcPlaylist->save($con);
                }
                $this->setCcPlaylist($this->aCcPlaylist);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = CcPlaylistcontentsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CcPlaylistcontentsPeer::ID . ')');
        }
        if (null === $this->id) {
            try {
                $stmt = $con->query("SELECT nextval('cc_playlistcontents_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CcPlaylistcontentsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '"id"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::PLAYLIST_ID)) {
            $modifiedColumns[':p' . $index++]  = '"playlist_id"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::FILE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"file_id"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::BLOCK_ID)) {
            $modifiedColumns[':p' . $index++]  = '"block_id"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::STREAM_ID)) {
            $modifiedColumns[':p' . $index++]  = '"stream_id"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '"type"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::POSITION)) {
            $modifiedColumns[':p' . $index++]  = '"position"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::TRACKOFFSET)) {
            $modifiedColumns[':p' . $index++]  = '"trackoffset"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::CLIPLENGTH)) {
            $modifiedColumns[':p' . $index++]  = '"cliplength"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::CUEIN)) {
            $modifiedColumns[':p' . $index++]  = '"cuein"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::CUEOUT)) {
            $modifiedColumns[':p' . $index++]  = '"cueout"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::FADEIN)) {
            $modifiedColumns[':p' . $index++]  = '"fadein"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::FADEOUT)) {
            $modifiedColumns[':p' . $index++]  = '"fadeout"';
        }
        if ($this->isColumnModified(CcPlaylistcontentsPeer::TUNEURL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"tuneurl_id"';
        }

        $sql = sprintf(
            'INSERT INTO "cc_playlistcontents" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"id"':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '"playlist_id"':
                        $stmt->bindValue($identifier, $this->playlist_id, PDO::PARAM_INT);
                        break;
                    case '"file_id"':
                        $stmt->bindValue($identifier, $this->file_id, PDO::PARAM_INT);
                        break;
                    case '"block_id"':
                        $stmt->bindValue($identifier, $this->block_id, PDO::PARAM_INT);
                        break;
                    case '"stream_id"':
                        $stmt->bindValue($identifier, $this->stream_id, PDO::PARAM_INT);
                        break;
                    case '"type"':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
                        break;
                    case '"position"':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case '"trackoffset"':
                        $stmt->bindValue($identifier, $this->trackoffset, PDO::PARAM_STR);
                        break;
                    case '"cliplength"':
                        $stmt->bindValue($identifier, $this->cliplength, PDO::PARAM_STR);
                        break;
                    case '"cuein"':
                        $stmt->bindValue($identifier, $this->cuein, PDO::PARAM_STR);
                        break;
                    case '"cueout"':
                        $stmt->bindValue($identifier, $this->cueout, PDO::PARAM_STR);
                        break;
                    case '"fadein"':
                        $stmt->bindValue($identifier, $this->fadein, PDO::PARAM_STR);
                        break;
                    case '"fadeout"':
                        $stmt->bindValue($identifier, $this->fadeout, PDO::PARAM_STR);
                        break;
                    case '"tuneurl_id"':
                        $stmt->bindValue($identifier, $this->tuneurl_id, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCcFiles !== null) {
                if (!$this->aCcFiles->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCcFiles->getValidationFailures());
                }
            }

            if ($this->aCcBlock !== null) {
                if (!$this->aCcBlock->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCcBlock->getValidationFailures());
                }
            }

            if ($this->aCcPlaylist !== null) {
                if (!$this->aCcPlaylist->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCcPlaylist->getValidationFailures());
                }
            }


            if (($retval = CcPlaylistcontentsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }



            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CcPlaylistcontentsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getDbId();
                break;
            case 1:
                return $this->getDbPlaylistId();
                break;
            case 2:
                return $this->getDbFileId();
                break;
            case 3:
                return $this->getDbBlockId();
                break;
            case 4:
                return $this->getDbStreamId();
                break;
            case 5:
                return $this->getDbType();
                break;
            case 6:
                return $this->getDbPosition();
                break;
            case 7:
                return $this->getDbTrackOffset();
                break;
            case 8:
                return $this->getDbCliplength();
                break;
            case 9:
                return $this->getDbCuein();
                break;
            case 10:
                return $this->getDbCueout();
                break;
            case 11:
                return $this->getDbFadein();
                break;
            case 12:
                return $this->getDbFadeout();
                break;
            case 13:
                return $this->getDbTuneurlId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['CcPlaylistcontents'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CcPlaylistcontents'][$this->getPrimaryKey()] = true;
        $keys = CcPlaylistcontentsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getDbId(),
            $keys[1] => $this->getDbPlaylistId(),
            $keys[2] => $this->getDbFileId(),
            $keys[3] => $this->getDbBlockId(),
            $keys[4] => $this->getDbStreamId(),
            $keys[5] => $this->getDbType(),
            $keys[6] => $this->getDbPosition(),
            $keys[7] => $this->getDbTrackOffset(),
            $keys[8] => $this->getDbCliplength(),
            $keys[9] => $this->getDbCuein(),
            $keys[10] => $this->getDbCueout(),
            $keys[11] => $this->getDbFadein(),
            $keys[12] => $this->getDbFadeout(),
            $keys[13] => $this->getDbTuneurlId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCcFiles) {
                $result['CcFiles'] = $this->aCcFiles->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCcBlock) {
                $result['CcBlock'] = $this->aCcBlock->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCcPlaylist) {
                $result['CcPlaylist'] = $this->aCcPlaylist->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CcPlaylistcontentsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setDbId($value);
                break;
            case 1:
                $this->setDbPlaylistId($value);
                break;
            case 2:
                $this->setDbFileId($value);
                break;
            case 3:
                $this->setDbBlockId($value);
                break;
            case 4:
                $this->setDbStreamId($value);
                break;
            case 5:
                $this->setDbType($value);
                break;
            case 6:
                $this->setDbPosition($value);
                break;
            case 7:
                $this->setDbTrackOffset($value);
                break;
            case 8:
                $this->setDbCliplength($value);
                break;
            case 9:
                $this->setDbCuein($value);
                break;
            case 10:
                $this->setDbCueout($value);
                break;
            case 11:
                $this->setDbFadein($value);
                break;
            case 12:
                $this->setDbFadeout($value);
                break;
            case 13:
                $this->setDbTuneurlId($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = CcPlaylistcontentsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setDbId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setDbPlaylistId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDbFileId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDbBlockId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDbStreamId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDbType($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setDbPosition($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDbTrackOffset($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDbCliplength($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setDbCuein($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setDbCueout($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setDbFadein($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setDbFadeout($arr[$keys[12]]);
        if (!empty($arr[$keys[13]])) $this->setDbTuneurlId($arr[$keys[13]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CcPlaylistcontentsPeer::DATABASE_NAME);

        if ($this->isColumnModified(CcPlaylistcontentsPeer::ID)) $criteria->add(CcPlaylistcontentsPeer::ID, $this->id);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::PLAYLIST_ID)) $criteria->add(CcPlaylistcontentsPeer::PLAYLIST_ID, $this->playlist_id);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::FILE_ID)) $criteria->add(CcPlaylistcontentsPeer::FILE_ID, $this->file_id);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::BLOCK_ID)) $criteria->add(CcPlaylistcontentsPeer::BLOCK_ID, $this->block_id);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::STREAM_ID)) $criteria->add(CcPlaylistcontentsPeer::STREAM_ID, $this->stream_id);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::TYPE)) $criteria->add(CcPlaylistcontentsPeer::TYPE, $this->type);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::POSITION)) $criteria->add(CcPlaylistcontentsPeer::POSITION, $this->position);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::TRACKOFFSET)) $criteria->add(CcPlaylistcontentsPeer::TRACKOFFSET, $this->trackoffset);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::CLIPLENGTH)) $criteria->add(CcPlaylistcontentsPeer::CLIPLENGTH, $this->cliplength);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::CUEIN)) $criteria->add(CcPlaylistcontentsPeer::CUEIN, $this->cuein);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::CUEOUT)) $criteria->add(CcPlaylistcontentsPeer::CUEOUT, $this->cueout);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::FADEIN)) $criteria->add(CcPlaylistcontentsPeer::FADEIN, $this->fadein);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::FADEOUT)) $criteria->add(CcPlaylistcontentsPeer::FADEOUT, $this->fadeout);
        if ($this->isColumnModified(CcPlaylistcontentsPeer::TUNEURL_ID)) $criteria->add(CcPlaylistcontentsPeer::TUNEURL_ID, $this->tuneurl_id);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(CcPlaylistcontentsPeer::DATABASE_NAME);
        $criteria->add(CcPlaylistcontentsPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getDbId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setDbId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getDbId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of CcPlaylistcontents (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDbPlaylistId($this->getDbPlaylistId());
        $copyObj->setDbFileId($this->getDbFileId());
        $copyObj->setDbBlockId($this->getDbBlockId());
        $copyObj->setDbStreamId($this->getDbStreamId());
        $copyObj->setDbTuneurlId($this->getDbTuneurlId());
        $copyObj->setDbType($this->getDbType());
        $copyObj->setDbPosition($this->getDbPosition());
        $copyObj->setDbTrackOffset($this->getDbTrackOffset());
        $copyObj->setDbCliplength($this->getDbCliplength());
        $copyObj->setDbCuein($this->getDbCuein());
        $copyObj->setDbCueout($this->getDbCueout());
        $copyObj->setDbFadein($this->getDbFadein());
        $copyObj->setDbFadeout($this->getDbFadeout());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setDbId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return CcPlaylistcontents Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return CcPlaylistcontentsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CcPlaylistcontentsPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a CcFiles object.
     *
     * @param                  CcFiles $v
     * @return CcPlaylistcontents The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCcFiles(CcFiles $v = null)
    {
        if ($v === null) {
            $this->setDbFileId(NULL);
        } else {
            $this->setDbFileId($v->getDbId());
        }

        $this->aCcFiles = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the CcFiles object, it will not be re-added.
        if ($v !== null) {
            $v->addCcPlaylistcontents($this);
        }


        return $this;
    }


    /**
     * Get the associated CcFiles object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return CcFiles The associated CcFiles object.
     * @throws PropelException
     */
    public function getCcFiles(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCcFiles === null && ($this->file_id !== null) && $doQuery) {
            $this->aCcFiles = CcFilesQuery::create()->findPk($this->file_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCcFiles->addCcPlaylistcontentss($this);
             */
        }

        return $this->aCcFiles;
    }

    /**
     * Declares an association between this object and a CcBlock object.
     *
     * @param                  CcBlock $v
     * @return CcPlaylistcontents The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCcBlock(CcBlock $v = null)
    {
        if ($v === null) {
            $this->setDbBlockId(NULL);
        } else {
            $this->setDbBlockId($v->getDbId());
        }

        $this->aCcBlock = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the CcBlock object, it will not be re-added.
        if ($v !== null) {
            $v->addCcPlaylistcontents($this);
        }


        return $this;
    }


    /**
     * Get the associated CcBlock object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return CcBlock The associated CcBlock object.
     * @throws PropelException
     */
    public function getCcBlock(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCcBlock === null && ($this->block_id !== null) && $doQuery) {
            $this->aCcBlock = CcBlockQuery::create()->findPk($this->block_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCcBlock->addCcPlaylistcontentss($this);
             */
        }

        return $this->aCcBlock;
    }

    /**
     * Declares an association between this object and a CcPlaylist object.
     *
     * @param                  CcPlaylist $v
     * @return CcPlaylistcontents The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCcPlaylist(CcPlaylist $v = null)
    {
        // aggregate_column_relation behavior
        if (null !== $this->aCcPlaylist && $v !== $this->aCcPlaylist) {
            $this->oldCcPlaylist = $this->aCcPlaylist;
        }
        if ($v === null) {
            $this->setDbPlaylistId(NULL);
        } else {
            $this->setDbPlaylistId($v->getDbId());
        }

        $this->aCcPlaylist = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the CcPlaylist object, it will not be re-added.
        if ($v !== null) {
            $v->addCcPlaylistcontents($this);
        }


        return $this;
    }


    /**
     * Get the associated CcPlaylist object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return CcPlaylist The associated CcPlaylist object.
     * @throws PropelException
     */
    public function getCcPlaylist(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCcPlaylist === null && ($this->playlist_id !== null) && $doQuery) {
            $this->aCcPlaylist = CcPlaylistQuery::create()->findPk($this->playlist_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCcPlaylist->addCcPlaylistcontentss($this);
             */
        }

        return $this->aCcPlaylist;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->playlist_id = null;
        $this->file_id = null;
        $this->block_id = null;
        $this->tuneurl_id = null;
        $this->stream_id = null;
        $this->type = null;
        $this->position = null;
        $this->trackoffset = null;
        $this->cliplength = null;
        $this->cuein = null;
        $this->cueout = null;
        $this->fadein = null;
        $this->fadeout = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->aCcFiles instanceof Persistent) {
              $this->aCcFiles->clearAllReferences($deep);
            }
            if ($this->aCcBlock instanceof Persistent) {
              $this->aCcBlock->clearAllReferences($deep);
            }
            if ($this->aCcPlaylist instanceof Persistent) {
              $this->aCcPlaylist->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aCcFiles = null;
        $this->aCcBlock = null;
        $this->aCcPlaylist = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CcPlaylistcontentsPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // aggregate_column_relation behavior

    /**
     * Update the aggregate column in the related CcPlaylist object
     *
     * @param PropelPDO $con A connection object
     */
    protected function updateRelatedCcPlaylist(PropelPDO $con)
    {
        if ($ccPlaylist = $this->getCcPlaylist()) {
            if (!$ccPlaylist->isAlreadyInSave()) {
                $ccPlaylist->updateDbLength($con);
            }
        }
        if ($this->oldCcPlaylist) {
            $this->oldCcPlaylist->updateDbLength($con);
            $this->oldCcPlaylist = null;
        }
    }

}
