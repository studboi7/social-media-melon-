class ImgUpload extends React.Component {
    render() {
      return (
        <label htmlFor="photo-upload" className="custom-file-upload fas">
          <div className="img-wrap img-upload">
            <img htmlFor="photo-upload" src={this.props.src} alt="Profile" />
          </div>
          <input id="photo-upload" type="file" onChange={this.props.onChange} />
        </label>
      );
    }
  }
  
  class Name extends React.Component {
    render() {
      return (
        <div className="field">
          <label htmlFor="name">name:</label>
          <input
            id="name"
            type="text"
            onChange={this.props.onChange}
            maxLength="25"
            value={this.props.value}
            placeholder="Alexa"
            required
          />
        </div>
      );
    }
  }
  
  class Status extends React.Component {
    render() {
      return (
        <div className="field">
          <label htmlFor="status">status:</label>
          <input
            id="status"
            type="text"
            onChange={this.props.onChange}
            maxLength="35"
            value={this.props.value}
            placeholder="It's a nice day!"
            required
          />
        </div>
      );
    }
  }
  
  class Profile extends React.Component {
    render() {
      return (
        <div className="card">
          <form onSubmit={this.props.onSubmit}>
            <h1>Profile Card</h1>
            <label className="custom-file-upload fas">
              <div className="img-wrap">
                <img htmlFor="photo-upload" src={this.props.src} alt="Profile" />
              </div>
            </label>
            <div className="name">{this.props.name}</div>
            <div className="status">{this.props.status}</div>
            <button type="submit" className="edit">Edit Profile</button>
          </form>
        </div>
      );
    }
  }
  
  class Edit extends React.Component {
    render() {
      return (
        <div className="card">
          <form onSubmit={this.props.onSubmit}>
            <h1>Profile Card</h1>
            {this.props.children}
            <button type="submit" className="save">Save</button>
          </form>
        </div>
      );
    }
  }
  
  class CardProfile extends React.Component {
    constructor(props) {
      super(props);
      this.state = {
        file: '',
        imagePreviewUrl: 'https://github.com/OlgaKoplik/CodePen/blob/master/profile.jpg?raw=true',
        name: '',
        status: '',
        active: 'edit'
      };
    }
  
    photoUpload = (e) => {
      e.preventDefault();
      const reader = new FileReader();
      const file = e.target.files[0];
      reader.onloadend = () => {
        this.setState({
          file: file,
          imagePreviewUrl: reader.result
        });
      };
      reader.readAsDataURL(file);
    }
  
    editName = (e) => {
      const name = e.target.value;
      this.setState({ name });
    }
  
    editStatus = (e) => {
      const status = e.target.value;
      this.setState({ status });
    }
  
    handleSubmit = (e) => {
      e.preventDefault();
      const activeP = this.state.active === 'edit' ? 'profile' : 'edit';
      this.setState({ active: activeP });
    }
  
    render() {
      const { imagePreviewUrl, name, status, active } = this.state;
      return (
        <div>
          {active === 'edit' ? (
            <Edit onSubmit={this.handleSubmit}>
              <ImgUpload onChange={this.photoUpload} src={imagePreviewUrl} />
              <Name onChange={this.editName} value={name} />
              <Status onChange={this.editStatus} value={status} />
            </Edit>
          ) : (
            <Profile
              onSubmit={this.handleSubmit}
              src={imagePreviewUrl}
              name={name}
              status={status}
            />
          )}
        </div>
      );
    }
  }
  
  ReactDOM.render(<CardProfile />, document.getElementById('root'));
  