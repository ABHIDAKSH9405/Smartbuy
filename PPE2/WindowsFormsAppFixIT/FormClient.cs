using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace WindowsFormsAppFixIT
{
    public partial class FormClient : Form
    {

        private string connectionString = @"Server=.\SQLEXPRESS;Database=Fixit;Trusted_Connection=True;";
        public FormClient()
        {
            InitializeComponent();
        }

        private void FormClient_Load(object sender, EventArgs e)
        {
            FillClient();
        }

        private void FillClient()
        {
            listBoxClient.Items.Clear();

            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();

            string sql = "select * from Client order by Nom";
            SqlCommand cmd = new SqlCommand(sql, cn);
            SqlDataReader drClient = cmd.ExecuteReader();
            while (drClient.Read())
            {
                string nom = drClient["Nom"].ToString();
                listBoxClient.Items.Add(nom);
            }

            drClient.Close();
            cn.Close();

            listBoxClient.Text = "";
        }

        private void listBoxClient_SelectedIndexChanged(object sender, EventArgs e)
        {
            // remplir les champs avec les bonnes valeurs !!!!!!!!!!!
            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "select * from client where nom = @nomclient";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@nomclient", listBoxClient.SelectedItem.ToString());
            SqlDataReader drclient = cmd.ExecuteReader();
            drclient.Read();
            textBoxNom.Text = drclient["Nom"].ToString();
            textBoxMail.Text = drclient["Mail"].ToString();
            textBoxTel.Text = drclient["Tel"].ToString();
            textBoxAdresse.Text = drclient["Adresse"].ToString();

            drclient.Close();
            cn.Close();

        }

        private void ClearFields()
        {
            textBoxNom.Text = "";
            textBoxMail.Text = "";
            textBoxTel.Text = "";
            textBoxAdresse.Text = "";
        }

        private bool IsPresent(string nomclient)
        {
            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "SELECT COUNT(*) FROM Client WHERE Nom = @thenom";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@thenom", nomclient);
            int count = (int)cmd.ExecuteScalar();
            cn.Close();
            return count > 0;
        }

        private void buttonAdd_Click(object sender, EventArgs e)
        {
            if (IsPresent(textBoxNom.Text))
            {
                MessageBox.Show("Client déjà présent");
                return;
            }
            if (textBoxNom.Text == "")
            {
                MessageBox.Show("Client vide");
                textBoxNom.Focus();
                return;
            }
            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "INSERT INTO CLIENT VALUES(@nom, @mail, @tel, @adresse)";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@nom", textBoxNom.Text);
            cmd.Parameters.AddWithValue("@mail", textBoxMail.Text);
            cmd.Parameters.AddWithValue("@tel", textBoxTel.Text);
            cmd.Parameters.AddWithValue("@adresse", textBoxAdresse.Text);
            cmd.ExecuteNonQuery();
            cn.Close();
            FillClient();
            ClearFields();
        }

        private void buttonModifier_Click(object sender, EventArgs e)
        {
            if ((listBoxClient.SelectedItem.ToString() != textBoxNom.Text)
                && (this.IsPresent(textBoxNom.Text)))
            {
                MessageBox.Show("Client déjà présent");
                return;
            }
            if (textBoxNom.Text == "")
            {
                MessageBox.Show("Nom vide");
                textBoxNom.Focus();
                return;
            }
            if (listBoxClient.SelectedIndex == -1)
            {
                MessageBox.Show("Veullez sélectionner un client");
                listBoxClient.Focus();
                return;
            }
            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "UPDATE CLIENT SET Nom = @nomclient, " +
                "mail = @mail ,tel = @tel" +
                ",Adresse = @adresse  WHERE Nom = @condclient";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@nomclient", textBoxNom.Text);
            cmd.Parameters.AddWithValue("@mail", textBoxMail.Text);
            cmd.Parameters.AddWithValue("@tel", textBoxTel.Text);
            cmd.Parameters.AddWithValue("@adresse", textBoxAdresse.Text);
            cmd.Parameters.AddWithValue("@condclient", listBoxClient.SelectedItem.ToString());

            cmd.ExecuteNonQuery();
            cn.Close();
            FillClient();
            ClearFields();
        }

        private void buttonDel_Click(object sender, EventArgs e)
        {
            if (listBoxClient.SelectedIndex == -1)
            {
                MessageBox.Show("Veullez sélectionner un client");
                listBoxClient.Focus();
                return;
            }
            if (MessageBox.Show("Voulez-vous vraiment supprimer ce client ?", "Confirmation", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.No)
            {
                return;
            }

            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();
            string sql = "DELETE FROM Client WHERE Nom = @oldNomClient";
            SqlCommand cmd = new SqlCommand(sql, cn);
            cmd.Parameters.AddWithValue("@oldNomClient", listBoxClient.SelectedItem.ToString());
            cmd.ExecuteNonQuery();
            cn.Close();
            FillClient();
            ClearFields();
        }
    }
}
